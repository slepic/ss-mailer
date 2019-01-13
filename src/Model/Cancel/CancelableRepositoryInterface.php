<?php

namespace SsMailer\Model\Cancel;

interface CancelableRepositoryInterface
{
    public function findById(): CancelableInterface;
}
