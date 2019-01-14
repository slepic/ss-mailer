<?php

namespace SsMailer\Tests\Applications;

class QueueTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        $this->repository = $this->createMock(\SsMailer\Model\Queue\RepositoryInterface::class);
        $this->application = new \SsMailer\Applications\Queue($this->repository);
    }

    public function testRun()
    {
        $this->repository->method('getEmailsToSend')
            ->willReturn(new \ArrayIterator([]));
        $this->application->run();
    }
}
