<?php

namespace App\Domains\Repositories;

use App\Domains\Models\Tld;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class TldRepository
{
    /** @var EntityRepository */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em->getRepository(Tld::class);
    }

    public function findAll()
    {
        return $this->em->findAll();
    }
}
