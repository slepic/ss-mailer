<?php

namespace SsMailer\Model\Cancel;

interface CancelableRepositoryInterface
{
    public function findById(string $requestId): ?CancelableInterface;
}
