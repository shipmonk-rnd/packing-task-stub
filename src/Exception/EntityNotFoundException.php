<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;

class EntityNotFoundException extends Exception
{
    public static function byId(string $entityName, int $id): self
    {
        return new self(sprintf('%s was not found in database by id: %d', $entityName, $id));
    }
}
