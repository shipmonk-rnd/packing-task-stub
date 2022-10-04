<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;

class PackagingNotFoundException extends Exception
{
    public static function byId(int $id): self
    {
        return new self(sprintf('Packaging was not found in database by id: %d', $id));
    }
}
