<?php

namespace App\Domains\Repositories;

use App\Domains\Models\Domain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DomainRepository
{
    /** @var EntityRepository */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em->getRepository(Domain::class);
    }

    public function findOneByDomain(string $domain)
    {
        return $this->em->findOneBy(['domain' => $domain]);
    }
}
