<?php

namespace SsMailer\Json\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Json\Send\ResponseFactory;
use stdClass;

class ResponseFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        $this->factory = new ResponseFactory();
    }

    public function testSuccessNoId(): void
    {
        $response = $this->factory->createSuccessResponse();
        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertTrue(isset($response->status));
        $this->assertTrue($response->status);
        $this->assertFalse(isset($response->errors));
        $this->assertFalse(isset($response->messageId));
    }

    public function testSuccessWithId(): void
    {
        $messageId = 'abcd';
        $response = $this->factory->createSuccessResponse($messageId);
        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertTrue(isset($response->status));
        $this->assertTrue($response->status);
        $this->assertFalse(isset($response->errors));
        $this->assertTrue(isset($response->messageId));
        $this->assertSame($messageId, $response->messageId);
    }

    public function testError(): void
    {
        $errors = ['a' => 1, 'b' => 2, 3];
        $response = $this->factory->createErrorResponse($errors);
        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertTrue(isset($response->status));
        $this->assertFalse($response->status);
        $this->assertTrue(isset($response->errors));
        $this->assertInstanceOf(stdClass::class, $response->errors);
    }
}
