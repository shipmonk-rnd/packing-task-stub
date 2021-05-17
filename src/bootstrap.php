<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;

require __DIR__ . '/../vendor/autoload.php';

$config = Setup::createAnnotationMetadataConfiguration([__DIR__], true, null, null, false);
$config->setNamingStrategy(new UnderscoreNamingStrategy());

return EntityManager::create([
    'driver' => 'pdo_mysql',
    'host' => 'mysql',
    'user' => 'root',
    'password' => 'secret',
    'dbname' => 'packing',
], $config);
