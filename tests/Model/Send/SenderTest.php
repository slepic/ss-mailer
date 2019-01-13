<?php

namespace SsMailer\Tests\Model\Send;

use PHPUnit\Framework\TestCase;
use SsMailer\Model\Send\Sender;
use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\Send\PersisterInterface;
use SsMailer\Model\MailerInterface;
use SsMailer\Model\EmailInterface;
use DateTime;

class SenderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->request = $this->createMock(RequestInterface::class);
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->persister = $this->createMock(PersisterInterface::class);

        $this->sender = new Sender($this->mailer, $this->persister);
    }

    public function testSendDelayed()
    {
        $delay = new DateTime('now + 5 minutes');
        $this->request->expects($this->once())
            ->method('isDelayed')
            ->willReturn(true);
        $this->request->expects($this->once())
            ->method('getSendDateTime')
            ->willReturn($delay);

        $testId = md5(time());
        $this->persister->expects($this->once())
            ->method('persistSendRequest')
            ->with($this->request)
            ->willReturn($testId);

        $result = $this->sender->sendEmail($this->request);
        $this->assertSame($testId, $result);
    }

    public function testSendImmediate()
    {
        $this->request->expects($this->once())
            ->method('isDelayed')
            ->willReturn(false);
        $this->request->expects($this->never())
            ->method('getSendDateTime');

        $email = $this->createMock(EmailInterface::class);
        $this->request->expects($this->once())
            ->method('getEmail')
            ->willReturn($email);

        $this->mailer->expects($this->once())
            ->method('sendEmail')
            ->with($email)
            ->willReturn(null);

        $result = $this->sender->sendEmail($this->request);
        $this->assertSame(null, $result);
    }

    public function testSendError()
    {
        $errors = ['error' => 'Error.'];
        $this->mailer->expects($this->once())
            ->method('sendEmail')
            ->willReturn($errors);

        $result = $this->sender->sendEmail($this->request);
        $this->assertSame($errors, $result);
    }
}
