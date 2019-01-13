<?php

namespace SsMailer\Tests\Json\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Json\Send\RequestFactory;
use SsMailer\Model\Send\RequestBuilderFactoryInterface;
use SsMailer\Model\Send\RequestBuilderInterface;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\EmailBuilderInterface;
use stdClass;

class RequestFactoryTest extends TestCase
{
    protected function setUp()
    {
        $this->builderFactory = $this->createMock(RequestBuilderFactoryInterface::class);
        $this->builder = $this->createMock(RequestBuilderInterface::class);
        $this->builderFactory->method('createRequestBuilder')
            ->willReturn($this->builder);
        $this->factory = new RequestFactory($this->builderFactory);
    }

    public function provideErrorData(): array
    {
        $data = [];
        $data[] = [null, ['input']];
        $data[] = [(object) ['from' => []], ['from']];
        $data[] = [(object) ['to' => 1], ['to']];
        $data[] = [(object) ['cc' => 1], ['cc']];
        $data[] = [(object) ['bcc' => 1], ['bcc']];
        $data[] = [(object) ['subject' => []], ['subject']];
        $data[] = [(object) ['body' => []], ['body']];
        $data[] = [(object) ['isHtml' => []], ['isHtml']];
        return $data;
    }

    /**
     * @dataProvider provideErrorData
     */
    public function testError($json, array $errorKeys)
    {
        $result = $this->factory->createRequest($json);
        $this->assertTrue(is_array($result));
        foreach ($errorKeys as $key) {
            $this->assertTrue(isset($result[$key]));
            $this->assertTrue(is_String($result[$key]));
        }
    }

    public function testFrom()
    {
        //using default builder for now
        $this->factory = new RequestFactory();
        $json = new stdClass();
        $json->from = 'a@b.c';
        $result = $this->factory->createRequest($json);
        $this->assertInstanceOf(RequestInterface::class, $result);
        $this->assertSame($json->from, $result->getEmail()->getFrom());
    }

    //TODO more
}
