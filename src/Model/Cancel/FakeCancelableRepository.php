<?php

namespace SsMailer\Model\Cancel;

/**
 * This is fake repository.
 * It behaves as if the request is not found if id contains letter 'e'.
 * It behaves as if the request has already been sent if id contains letter 'c'.
 * It will throw an exception if the id contains letter 't'.
 * Otherwise it behaves as it he request is successfully canceled.
 */
class FakeCancelableRepository implements CancelableRepositoryInterface
{
    public function findById(string $requestId): ?CancelableInterface
    {
        if (strpos($requestId, 'e') !== false) {
            return null;
        }
        if (strpos($requestId, 'c') !== false) {
            return new class implements CancelableInterface {
                public function canCancel(): bool
                {
                    return false;
                }
                public function cancel(): void
                {
                }
            };
        }
        if (strpos($requestId, 't') !== false) {
            throw new Exception('This is a test what happens if repository throws.');
        }
        return new class implements CancelableInterface {
            public function canCancel(): bool
            {
                return true;
            }
            public function cancel(): void
            {
            }
        };
    }
}
