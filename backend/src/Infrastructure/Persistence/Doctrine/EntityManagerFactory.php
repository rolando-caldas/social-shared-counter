<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    public function build($connection) : EntityManager
    {
        Type::addType(
            'ShareId',
            'App\Infrastructure\Domain\Entity\Share\DoctrineShareId'
        );

        return EntityManager::create($connection, Setup::createYAMLMetadataConfiguration([__DIR__ . '/Mapping'], false));
    }
}