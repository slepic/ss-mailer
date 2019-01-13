<?php

namespace SsMailer\Model\Cancel;

interface CancelableInterface
{
    public function canCancel(): bool;
    public function cancel(): void;
}
