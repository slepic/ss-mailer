<?php

namespace SsMailer\Tests\Json\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Json\Send\Handler;
use SsMailer\Json\Send\RequestFactoryInterface as RequestFactory;
use SsMailer\Json\Send\ResponseFactoryInterface as ResponseFactory;
use SsMailer\Model\Send\SenderInterface as Sender;
use SsMailer\Model\Send\RequestInterface as Request;
use stdClass;

class HandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->requestFactory = $this->createMock(RequestFactory::class);
        $this->sender = $this->createMock(Sender::class);
        $this->responseFactory = $this->createMock(ResponseFactory::class);
        $this->handler = new Handler($this->requestFactory, $this->responseFactory, $this->sender);
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
        $this->requestFactory->method('createRequest')
            ->with($inputJson)
            ->willReturn($errors);

        $response = new stdClass();
        $this->responseFactory->method('createInputErrorResponse')
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
    public function testHandleErrorSend($inputJson, array $errors)
    {
        $request = $this->createMock(Request::class);
        $this->requestFactory->method('createRequest')
            ->with($inputJson)
            ->willReturn($request);

        $this->sender->method('sendEmail')
            ->with($request)
            ->willReturn($errors);

        $jsonResponse = new stdClass();
        $this->responseFactory->method('createProcessErrorResponse')
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
        $request = $this->createMock(Request::class);
        $this->requestFactory->method('createRequest')
            ->with($inputJson)
            ->willReturn($request);

        $messageId = \md5(\time());
        $this->sender->method('sendEmail')
            ->with($request)
            ->willReturn($messageId);

        $jsonResponse = new stdClass();
        $this->responseFactory->method('createSuccessResponse')
            ->with($messageId)
            ->willReturn($jsonResponse);

        $outputJson = $this->handler->handle($inputJson);
        $this->assertSame($jsonResponse, $outputJson);
    }
}
