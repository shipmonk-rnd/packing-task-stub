<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require __DIR__ . '/../vendor/autoload.php';

return EntityManager::create([
    'driver' => 'pdo_pgsql',
    'host' => 'postgres',
    'user' => 'root',
    'password' => 'secret',
], Setup::createAnnotationMetadataConfiguration([__DIR__], true, null, null, false));
