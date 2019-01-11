<?php

namespace SsMailer\Model;

interface ErroneousInterface
{
    public function hasErrors(): bool;
    public function getErrors(): array;
}
