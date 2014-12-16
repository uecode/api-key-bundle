<?php

namespace Uecode\Bundle\ApiKeyBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class ApiKeyUser extends BaseUser implements UserInterface, AdvancedUserInterface, BaseUserInterface
{
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apikey     = '';
        for ($i = 0; $i < 64; $i++) {
            $apikey .= $characters[rand(0, strlen($characters) - 1)];
        }
        $apikey = base64_encode(sha1(uniqid('ue' . rand(rand(), rand())) . $apikey));
        $this->apiKey = $apikey;
    }
}
