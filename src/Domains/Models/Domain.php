<?php

namespace App\Domains\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="domain")
 */
class Domain
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $domain;
}
