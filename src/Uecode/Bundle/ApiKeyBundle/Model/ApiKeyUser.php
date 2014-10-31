<?php

namespace Uecode\Bundle\ApiKeyBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;

/**
 * @MappedSuperclass
 */
class ApiKeyUser extends BaseUser implements UserInterface, AdvancedUserInterface, BaseUserInterface
{
    /**
     * @ORM\Column(name="api_key", type="string", length=255, nullable=true)
     */
    protected $apiKey;

    public function __construct()
    {
        $this->generateApiKey();
        parent::__construct();
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Generates an API Key
     */
    public function generateApiKey()
    {
        $apikey = hash('sha256', uniqid() . time() . rand());
        $this->apiKey = $apikey;
    }
}
