<?php

namespace SsMailer\Tests\Json\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Json\Send\Handler;
use SsMailer\Json\Send\ResponseFactoryInterface as ResponseFactory;
use SsMailer\Json\Send\RequestReaderFactoryInterface as ReaderFactory;
use SsMailer\Model\Send\RequestReaderInterface as RequestReader;
use SsMailer\Model\Send\SenderInterface as Sender;
use SsMailer\Model\Send\RequestInterface as EmailRequest;
use SsMailer\Model\Send\ResponseInterface as Response;
use stdClass;

class HandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->emailRequest = $this->createMock(EmailRequest::class);
        $this->reader = $this->createMock(RequestReader::class);
        $this->reader->method('getRequest')
            ->willReturn($this->emailRequest);
        $this->response = $this->createMock(Response::class);
        $this->readerFactory = $this->createMock(ReaderFactory::class);
        $this->responseFactory = $this->createMock(ResponseFactory::class);
        $this->sender = $this->createMock(Sender::class);
        $this->handler = new Handler($this->readerFactory, $this->responseFactory, $this->sender);
    }

    public function provideHandleBadInputData(): array
    {
        $data = [];
        $data[] = [new stdClass(), ['key' => 'Error message.']];
        return $data;
    }

    /**
     * @dataProvider provideHandleBadInputData
     */
    public function testHandleBadInput($inputJson, $errors)
    {
        $this->readerFactory->method('createRequestReader')
            ->with($inputJson)
            ->willReturn($this->reader);

        $this->reader->method('hasErrors')
            ->willReturn(true);
        $this->reader->method('getErrors')
            ->willReturn($errors);

        $response = new stdClass();
        $this->responseFactory->method('createErrorResponse')
            ->with($errors)
            ->willReturn($response);

        $outputJson = $this->handler->handle($inputJson);
        $this->assertSame($response, $outputJson);
    }
    
    public function provideHandleErrorSendData(): array
    {
        $data = [];
        $data[] = [new stdClass(), ['key' => 'Error message.']];
        return $data;
    }

    /**
     * @dataProvider provideHandleBadInputData
     */
    public function testHandleErrorSend($inputJson, $errors)
    {
        $this->readerFactory->method('createRequestReader')
            ->with($inputJson)
            ->willReturn($this->reader);

        $this->reader->method('hasErrors')
            ->willReturn(false);

        $this->sender->method('sendEmail')
            ->with($this->emailRequest)
            ->willReturn($this->response);

        $this->response->method('hasErrors')
            ->willReturn(true);
        $this->response->method('getErrors')
            ->willReturn($errors);

        $jsonResponse = new stdClass();
        $this->responseFactory->method('createErrorResponse')
            ->with($errors)
            ->willReturn($jsonResponse);

        $outputJson = $this->handler->handle($inputJson);
        $this->assertSame($jsonResponse, $outputJson);
    }

    /**
     * @dataProvider provideHandleBadInputData
     */
    public function testHandleSuccessSend($inputJson, $errors)
    {
        $this->readerFactory->method('createRequestReader')
            ->with($inputJson)
            ->willReturn($this->reader);

        $this->reader->method('hasErrors')
            ->willReturn(false);

        $this->sender->method('sendEmail')
            ->with($this->emailRequest)
            ->willReturn($this->response);

        $this->response->method('hasErrors')
            ->willReturn(false);

        $jsonResponse = new stdClass();
        $this->responseFactory->method('createSuccessResponse')
            ->willReturn($jsonResponse);

        $outputJson = $this->handler->handle($inputJson);
        $this->assertSame($jsonResponse, $outputJson);
    }
}
