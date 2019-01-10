<?php

namespace SsMailer\Json;

class NativeCoder implements CoderInterface
{
    public function decode(string $json)
    {
        return \json_decode($json);
    }

    public function encode($json): string
    {
        return \json_encode($json);
    }
}
