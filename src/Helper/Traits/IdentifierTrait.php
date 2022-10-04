<?php

namespace App\Helper\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdentifierTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
