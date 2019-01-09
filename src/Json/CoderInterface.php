<?php

namespace SsMailer\Json;

interface CoderInterface
{
    /**
     * @param string $json
     * @return scalar|array|stdClass
     */
    public function decode(string $json);

    /**
     * @param scalar|array|JsonSerializable
     * @return string
     */
    public function encode($json): string;
}
