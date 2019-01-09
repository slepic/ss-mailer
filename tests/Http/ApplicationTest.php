<?php

namespace SsMailer\Tests\Http;

use PHPUnit\Framework\TestCase;
use SsMailer\Http\Application;
use SsMailer\Http\ServerRequestFactoryInterface as RequestFactory;
use SsMailer\Http\ResponseSenderInterface as ResponseSender;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class ApplicationTest extends TestCase
{
    protected function setUp()
    {
        $this->handler = $this->createMock(Handler::class);
        $this->requestFactory = $this->createMock(RequestFactory::class);
        $this->responseSender = $this->createMock(ResponseSender::class);

        $this->application = new Application($this->handler, $this->requestFactory, $this->responseSender);
    }

    public function testRun()
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $this->requestFactory->method('createServerRequest')
            ->willReturn($request);
        $this->requestFactory->expects($this->once())
            ->method('createServerRequest');

        $this->handler->method('handle')
            ->with($request)
            ->willReturn($response);
        $this->handler->expects($this->once())
            ->method('handle')
            ->with($request);

        $this->responseSender->expects($this->once())
            ->method('sendResponse')
            ->with($response);

        $this->application->run();
    }
}
