<?php

namespace SmsConsumer;

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;

class EntityManager
{
    private $em;

    public function __construct()
    {
        $dotenv = new Dotenv(__DIR__.'/../');
        $dotenv->load();

        $paths = array(__DIR__.'/../src/Entity');
        $isDevMode = true;

        $dbParams = array(
            'host' => getenv('DATABASE_HOST'),
            'driver' => getenv('DATABASE_DRIVER'),
            'user' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'dbname' => getenv('DATABASE_NAME'),
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $this->em = \Doctrine\ORM\EntityManager::create($dbParams, $config);
    }

    public function get()
    {
        return $this->em;
    }
}
