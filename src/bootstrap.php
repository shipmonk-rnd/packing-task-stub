<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration([__DIR__], true, __DIR__ . '/cache');
$config->setNamingStrategy(new UnderscoreNamingStrategy());

return EntityManager::create([
    'driver' => 'pdo_mysql',
    'host' => 'shipmonk-packing-mysql',
    'user' => 'root',
    'password' => 'secret',
    'dbname' => 'packing',
], $config);
