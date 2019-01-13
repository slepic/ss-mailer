<?php

namespace SsMailer\Model\Cancel;

/**
 * This is fake repository.
 * It behaves as if the request is not found if id contains letter 'e'.
 * It behaves as if the request has already been sent if id contains letter 'c'.
 * It will throw an exception if the id contains letter 't'.
 * Otherwise it behaves as it he request is successfully canceled.
 */
class FakeCancelableRepository implements CancelableRepository
{
    public function findById(string $requestId): CancelableInterface
    {
        if (strpos('e', $requestId) !== false) {
            return null;
        }
        if (strpos('c', $requestId) !== false) {
            return new class implements CancelableInterface {
                public function canCancel(): bool
                {
                    return false;
                }
                public function cance(): void
                {
                }
            };
        }
        if (strpos('t', $requestId) !== false) {
            throw new Exception('This is a test what happens if repository throws.');
        }
        return new class implements CancelableInterface {
            public function canCancel(): bool
            {
                return true;
            }
            public function cance(): void
            {
            }
        };
    }
}
