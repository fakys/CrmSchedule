<?php
namespace App\Services\Abstracts\Infrastructure\Repositories\DataBase;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class AbstractDoctrineBaseRepository extends EntityRepository
{
    protected EntityRepository $repositoryManager;
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repositoryManager = $this->em->getRepository($this->getEntityClass());

        parent::__construct($this->em, new ClassMetadata($this->getEntityClass()));
    }

    abstract protected function getEntityClass(): string;
}
