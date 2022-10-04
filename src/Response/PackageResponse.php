<?php
declare(strict_types=1);

namespace App\Response;

use App\Entity\Packaging;
use GuzzleHttp\Psr7\Response;

class PackageResponse extends Response
{
    public const FIELD_ID = 'id';
    public const FIELD_WIDTH = 'width';
    public const FIELD_HEIGHT = 'height';
    public const FIELD_LENGTH = 'length';
    public const FIELD_MAX_WEIGHT = 'max_weight';

    public function __construct(Packaging $packaging)
    {
        parent::__construct(200, [], (string) json_encode(self::packagingToResponse($packaging)));
    }

    /**
     * @param Packaging $packaging
     * @return array<mixed>
     */
    private static function packagingToResponse(Packaging $packaging): array
    {
        return [
            self::FIELD_ID => $packaging->getId(),
            self::FIELD_WIDTH => $packaging->getWidth(),
            self::FIELD_HEIGHT => $packaging->getHeight(),
            self::FIELD_LENGTH => $packaging->getLength(),
            self::FIELD_MAX_WEIGHT => $packaging->getMaxWeight(),
        ];
    }
}
