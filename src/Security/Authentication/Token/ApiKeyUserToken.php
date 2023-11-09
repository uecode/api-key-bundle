<?php

namespace Uecode\Bundle\ApiKeyBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class ApiKeyUserToken extends AbstractToken
{
    /**
     * @var string
     */
    protected $apiKey;

    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        $this->setAuthenticated(sizeof($roles) > 0);
    }

    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    public function getCredentials()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
