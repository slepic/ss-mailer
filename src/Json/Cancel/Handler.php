<?php

namespace SsMailer\Json\Cancel;

use SsMailer\Json\HandlerInterface;
use SsMailer\Json\ResponseFactoryInteface;
use SsMailer\Json\DefaultResponseFactory;
use SsMailer\Model\Cancel\CancelableRepositoryInterface;

class Handler implements HandlerInterface
{
    private $repository;
    private $responseFactory;

    public function __construct(CancelableRepositoryInterface $repository, ResponseFactoryInterface $responseFactory = null)
    {
        $this->repository = $repository;
        $this->responseFactory = $responseFactory ?: new DefaultResponseFactory();
    }

    public function handle($json)
    {
        if (!$json instanceof stdClass) {
            return $this->responseFactory->createErrorResponse(['input' => 'Expexted object.']);
        }
        if (!isset($json->id)) {
            return $this->responseFactory->createErrorResponse(['id' => 'Missing reuired ID']);
        }
        if (!is_string($json->id) || $json->id === '') {
            return $this->responseFactory->createErrorResponse(['id' => 'Id must be non-empty string.']);
        }
        $request = $this->repository->findById($requestId);
        if ($request === null) {
            return $this->createErrorResponse(['id' => 'Request not found.']);
        }
        if ($request->canCancel()) {
            $request->cancel();
            return $this->responseFactory->createSuccessResponse();
        }
        return $this->responseFactory->createErrorResponse(['state' => 'Request cannot be canceled.']);
    }
}
