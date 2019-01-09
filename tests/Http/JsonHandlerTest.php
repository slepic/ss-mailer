<?php

namespace SsMailer\Tests\Http;

use PHPUnit\Framework\TestCase;
use SsMailer\Http\JsonHandler as Handler;
use SsMailer\Json\HandlerInterface as JsonHandler;
use SsMailer\Json\CoderInterface as JsonCoder;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Message\StreamInterface as Stream;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class JsonHandlerTest extends TestCase
{
    protected function setUp()
    {
        $this->jsonHandler = $this->createMock(JsonHandler::class);
        $this->responseFactory = $this->createMock(ResponseFactory::class);
        $this->streamFactory = $this->createMock(StreamFactory::class);
        $this->jsonCoder = $this->createMock(JsonCoder::class);

        $this->handler = new Handler($this->jsonHandler, $this->responseFactory, $this->streamFactory, $this->jsonCoder);
    }

    public function provideHandleData(): array
    {
        return [
            ['{}', '{status:true}'],
            ['[]', '{}'],
            ['blblabla', 'this data should be irrelevant as long as it is strings'],
        ];
    }

    /**
     * @dataProvider provideHandleData
     */
    public function testHandle($requestBody, $responseBody)
    {
//        $requestBody = '{}';
        $decodedRequestBody = new \stdClass();
        $decodedResponseBody = new \stdClass();
        $decodedResponseBody->status = true;
//        $responseBody = '{status:true}';

        $requestStream = $this->createMock(Stream::class);
        $requestStream->method('__toString')
            ->willReturn($requestBody);

        $request = $this->createMock(Request::class);
        $request->method('getBody')
            ->willReturn($requestStream);

        $this->jsonCoder->method('decode')
            ->with($requestBody)
            ->willReturn($decodedRequestBody);

        $this->jsonHandler->method('handle')
            ->with($decodedRequestBody)
            ->willReturn($decodedResponseBody);

        $this->jsonCoder->method('encode')
            ->with($decodedResponseBody)
            ->willReturn($responseBody);

        $responseStream = $this->createMock(Stream::class);

        $response = $this->createMock(Response::class);
        $response->method('getBody')
            ->willReturn($responseStream);

        $this->responseFactory->method('createResponse')
            ->with(200)
            ->willReturn($response);

        $this->streamFactory->method('createStream')
            ->with($responseBody)
            ->willReturn($responseStream);

        $response->method('withBody')
            ->with($responseStream)
            ->willReturn($response);

        $result = $this->handler->handle($request);

        $this->assertSame($response, $result);
    }
}
