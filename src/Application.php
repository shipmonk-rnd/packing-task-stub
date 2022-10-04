<?php

namespace App;

use App\Facade\PackageFacade;
use App\Response\PackageResponse;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{

    private PackageFacade $packageFacade;

    public function __construct(
        PackageFacade $packageFacade
    ) {
        $this->packageFacade = $packageFacade;
    }

    public function run(
        EntityManager $entityManager,
        RequestInterface $request
    ): ResponseInterface {
        $package = $this->packageFacade->findBestPackaging($entityManager, $request);
        return new PackageResponse($package);
    }
}
