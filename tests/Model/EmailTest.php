<?php

namespace SsMailer\Test\Model;

use PHPUnit\Framework\TestCase;
use SsMailer\Model\Email;

class EmailTest extends TestCase
{
    protected function setUp(): void
    {
        $this->email = new Email();
    }

    public function testFrom()
    {
        $testValue = \md5(\time());
        $this->email->setFrom($testValue);
        $this->assertSame($testValue, $this->email->getFrom());
    }

    public function testTo()
    {
        $testValue = [];
        $this->email->setTo($testValue);
        $this->assertSame($testValue, $this->email->getTo());
    }

    public function testCc()
    {
        $testValue = [];
        $this->email->setCc($testValue);
        $this->assertSame($testValue, $this->email->getCc());
    }

    public function testBcc()
    {
        $testValue = [];
        $this->email->setBcc($testValue);
        $this->assertSame($testValue, $this->email->getBcc());
    }

    public function testSubject()
    {
        $testValue = \md5(\time());
        $this->email->setSubject($testValue);
        $this->assertSame($testValue, $this->email->getSubject());
    }

    public function testBody()
    {
        $testValue = \md5(\time());
        $this->email->setBody($testValue);
        $this->assertSame($testValue, $this->email->getBody());
    }

    public function testIsHtml()
    {
        $testValue = true;
        $this->email->setIsHtml($testValue);
        $this->assertSame($testValue, $this->email->isHtml());
        $testValue = false;
        $this->email->setIsHtml($testValue);
        $this->assertSame($testValue, $this->email->isHtml());
    }

    public function testBuild()
    {
        $email = $this->email->buildEmail();
        $this->assertSame($this->email->getFrom(), $email->getFrom());
        $this->assertSame($this->email->getTo(), $email->getTo());
        $this->assertSame($this->email->getCc(), $email->getCc());
        $this->assertSame($this->email->getBcc(), $email->getBcc());
        $this->assertSame($this->email->getSubject(), $email->getSubject());
        $this->assertSame($this->email->getBody(), $email->getBody());
        $this->assertSame($this->email->isHtml(), $email->isHtml());
    }

    public function testBuildFrom()
    {
        $this->testFrom();
        $this->testBuild();
    }

    public function testBuildTo()
    {
        $this->testTo();
        $this->testBuild();
    }

    public function testBuildCc()
    {
        $this->testCc();
        $this->testBuild();
    }

    public function testBuildBcc()
    {
        $this->testBcc();
        $this->testBuild();
    }

    public function testBuildSubject()
    {
        $this->testSubject();
        $this->testBuild();
    }

    public function testBuildBody()
    {
        $this->testBody();
        $this->testBuild();
    }

    public function testBuildIsHtml()
    {
        $this->testIsHtml();
        $this->testBuild();
    }
}
