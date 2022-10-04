<?php

use App\Application;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/** @var EntityManager $entityManager */
$entityManager = require __DIR__ . '/src/bootstrap.php';

$container = new ContainerBuilder();

/* $doctrineBundle = new DoctrineBundle();
$doctrineBundle->setContainer($container);
$doctrineBundle->build($container);
$doctrineBundle->boot(); */

$loader = new YamlFileLoader($container, new FileLocator(__DIR__));

$loader->load(__DIR__ . '/src/config/services.yaml');
// $loader->load(__DIR__ . '/src/config/packages/doctrine.yaml');

$container->compile();

$request = new Request('POST', new Uri('http://localhost/pack'), ['Content-Type' => 'application/json'], $argv[1]);

/** @var Application $app */
$app = $container->get(Application::class);
$response = $app->run($entityManager, $request);

echo "<<< In:\n" . Message::toString($request) . "\n\n";
echo ">>> Out:\n" . Message::toString($response) . "\n\n";

/* $application = new Application($entityManager);
$response = $application->run($request); */
