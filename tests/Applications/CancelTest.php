<?php

namespace SsMailer\Tests\Applications;

class CancelTest extends \PHPUnit\Framework\TestCase
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
        $this->application = new \SsMailer\Applications\Cancel($this->requestFactory, $this->responseSender);
    }

    public function provideCancelData(): array
    {
        $justError = '"status":false';
        $data = [];
        $data[] = ['{"id":"e"}', [$justError, 'not found']];
        $data[] = ['{"id":"c"}', [$justError, 'cannot']];
        $data[] = ['{"id":"g"}', ['"status":true']];
        return $data;
    }

    /**
     * @dataProvider provideCancelData
     */
    public function testCancel($requestBody, $responseBody)
    {
        $this->requestStream->method('__toString')
            ->willReturn($requestBody);

        $this->responseSender->expects($this->once())
            ->method('sendResponse')
            ->with($this->callback(function ($response) use ($responseBody) {
                $body = (string) $response->getBody();
                foreach ($responseBody as $rb) {
                    $this->assertContains($rb, $body);
                }
                return true;
            }));
        $this->application->run();
    }
}
