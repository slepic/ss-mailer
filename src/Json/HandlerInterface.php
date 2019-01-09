<?php

namespace SsMailer\Json;

interface HandlerInterface
{
    /**
     * @param scalar|array|stdClass
     * @return scalar|array|JsonSerializable
     */
    public function handle($request);
}
