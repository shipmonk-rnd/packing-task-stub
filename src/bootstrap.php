<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration([__DIR__], true);
$config->setNamingStrategy(new UnderscoreNamingStrategy());

return new EntityManager(DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'shipmonk-packing-mysql',
    'user' => 'root',
    'password' => 'secret',
    'dbname' => 'packing',
]), $config);
