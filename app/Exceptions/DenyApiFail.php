<?php
namespace App\Exceptions;

use Throwable;
use Ubient\PwnedPasswords\Contracts\LookupErrorHandler;

class DenyApiFail implements LookupErrorHandler
{

    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception, string $password): bool
    {
        return false;
    }
}
