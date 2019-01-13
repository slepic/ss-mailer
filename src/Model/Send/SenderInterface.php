<?php

namespace SsMailer\Model\Send;

interface SenderInterface
{
    /**
     * If there was an ID assigned to the request then it is returned, otherwise null is returned.
     * If there is an error during send, array of string messages must be returned.
     *
     * @return null|string|string[] Returns null or string on success. Array of error messages on failure.
     */
    public function sendEmail(RequestInterface $request);
}
