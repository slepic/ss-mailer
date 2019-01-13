<?php

namespace SsMailer\Test\Model\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Model\Send\Request;
use SsMailer\Model\EmailInterface;
use SsMailer\Model\EmailBuilderInterface;
use DateTime;

class RequestTest extends TestCase
{
    protected function setUp()
    {
        $this->emailBuilder = $this->createMock(EmailBuilderInterface::class);
        $this->request = new Request($this->emailBuilder);
    }

    public function testEmailBuilder()
    {
        $this->assertSame($this->emailBuilder, $this->request->getEmailBuilder());
    }

    public function testSendDateTime()
    {
        $testValue = new DateTime();
        $this->assertFalse($this->request->isDelayed());
        $this->request->setSendDateTime($testValue);
        $this->assertTrue($this->request->isDelayed());
        $this->assertSame($testValue, $this->request->getSendDateTime());
    }

    public function testEmail()
    {
        $testValue = $this->createMock(EmailInterface::class);
        $this->request->setEmail($testValue);
        $this->assertSame($testValue, $this->request->getEmail());
    }

    public function testBuild()
    {
        $request = $this->request->buildRequest();
        $this->assertEquals($this->request->getEmailBuilder(), $request->getEmailBuilder());
        $this->assertSame($this->request->isDelayed(), $request->isDelayed());
        if ($request->isDelayed()) {
            $this->assertEquals($this->request->getSendDateTime(), $request->getSendDateTime());
        }
    }
}
