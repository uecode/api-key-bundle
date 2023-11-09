<?php

namespace Uecode\Bundle\ApiKeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Uecode\Bundle\ApiKeyBundle\Model\ApiKeyUser as BaseUser;

/**
 * @MappedSuperclass
 */
class ApiKeyUser extends BaseUser
{
    /**
     * @ORM\Column(name="api_key", type="string", length=255, nullable=true)
     */
    protected $apiKey;
}
