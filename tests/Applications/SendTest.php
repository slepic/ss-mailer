<?php

namespace SsMailer\Tests\Applications;

class SendTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        $this->requestFactory = $this->createMock(\SsMailer\Http\ServerRequestFactoryInterface::class);
        $this->responseSender = $this->createMock(\SsMailer\Http\ResponseSenderInterface::class);
        $this->request = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        $this->requestFactory->method('createServerRequest')
            ->willReturn($this->request);
        $this->requestStream = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $this->request->method('getBody')
            ->willReturn($this->requestStream);

        //runs the use case over http
        $this->application = new \SsMailer\Applications\Send($this->requestFactory, $this->responseSender);
    }

    public function provideSendData(): array
    {
        $justSuccess = '{"status":true}';
        $data = [];
        $data[] = ['{}',$justSuccess];
        $data[] = ['{"from":"a@b.c"}',$justSuccess];
        $data[] = ['{"to":"a@b.c"}',$justSuccess];
        $data[] = ['{"cc":"a@b.c"}',$justSuccess];
        $data[] = ['{"bcc":"a@b.c"}',$justSuccess];
        $data[] = ['{"subject":"a@b.c"}',$justSuccess];
        return $data;
    }

    /**
     * @dataProvider provideSendData
     */
    public function testSend($requestBody, $responseBody)
    {
        $this->requestStream->method('__toString')
            ->willReturn($requestBody);

        $this->responseSender->expects($this->once())
            ->method('sendResponse')
            ->with($this->callback(function ($response) use ($responseBody) {
                $body = (string) $response->getBody();
                $this->assertSame($responseBody, $body);
                return true;
            }));
        $this->application->run();
    }

    public function provideErrorData(): array
    {
        $justError = '"status":false';
        $data = [];
        $data[] = ['{"from":[]}',$justError];
        $data[] = ['{"to":{}}',$justError];
        $data[] = ['{"cc":{}}',$justError];
        $data[] = ['{"bcc":{}}',$justError];
        $data[] = ['{"subject":[]}',$justError];
        return $data;
    }

    /**
     * @dataProvider provideErrorData
     */
    public function testError($requestBody, $responseBody)
    {
        $this->requestStream->method('__toString')
            ->willReturn($requestBody);

        $this->responseSender->expects($this->once())
            ->method('sendResponse')
            ->with($this->callback(function ($response) use ($responseBody) {
                $body = (string) $response->getBody();
                $this->assertContains($responseBody, $body);
                return true;
            }));
        $this->application->run();
    }
}
