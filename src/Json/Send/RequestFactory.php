<?php

namespace SsMailer\Json\Send;

use SsMailer\Model\Send\RequestInterface;
use SsMailer\Model\Send\RequestBuilderFactoryInterface as BuilderFactory;
use SsMailer\Model\Send\Request as DefaultBuilderFactory;
use stdClass;

class RequestFactory implements RequestFactoryInterface
{
    private $bulderFactory;

    public function __construct(BuilderFactory $builderFactory = null)
    {
        $this->builderFactory = $builderFactory ?: new DefaultBuilderFactory();
    }

    public function createRequest($json)
    {
        if (!$json instanceof stdClass) {
            return ['input' => 'Expected single object.'];
        }

        $errors = [];
        $builder = $this->builderFactory->createRequestBuilder();
        $emailBuilder = $builder->getEmailBuilder();
        if (isset($json->from)) {
            if (is_string($json->from)) {
                $emailBuilder->setFrom($json->from);
            } else {
                $errors['from'] = 'Field "from" must be a string.';
            }
        }
        if (isset($json->to)) {
            if (is_string($json->to)) {
                $to = explode(',', $json->to);
                $emailBuilder->setTo($to);
            } elseif (is_array($json->to)) {
                $emailBuilder->setTo($json->to);
            } else {
                $errors['to'] = 'Field "to" must be a string or array of string.';
            }
        }
        if (isset($json->cc)) {
            if (is_string($json->cc)) {
                $cc = explode(',', $json->cc);
                $emailBuilder->setCc($cc);
            } elseif (is_array($json->cc)) {
                $emailBuilder->setCc($json->cc);
            } else {
                $errors['cc'] = 'Field "cc" must be a string or array of string.';
            }
        }
        if (isset($json->bcc)) {
            if (is_string($json->bcc)) {
                $bcc = explode(',', $json->bcc);
                $emailBuilder->setBcc($bcc);
            } elseif (is_array($json->bcc)) {
                $emailBuilder->setBcc($json->bcc);
            } else {
                $errors['bcc'] = 'Field "bcc" must be a string or array of string.';
            }
        }
        if (isset($json->subject)) {
            if (is_string($json->subject)) {
                $emailBuilder->setSubject($json->subject);
            } else {
                $errors['subject'] = 'Field "subject" must be a string.';
            }
        }
        if (isset($json->body)) {
            if (is_string($json->body)) {
                $emailBuilder->setBody($json->body);
            } else {
                $errors['body'] = 'Field "body" must be a string.';
            }
        }
        if (isset($json->isHtml)) {
            if (is_bool($json->isHtml)) {
                $emailBuilder->setIsHtml($json->isHtml);
            } else {
                $errors['isHtml'] = 'Field "isHtml" must be boolean.';
            }
        }
        if (empty($errors)) {
            return $builder->buildRequest();
        }
        return $errors;
    }
}
