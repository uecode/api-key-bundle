<?php
namespace Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider;

use FOS\UserBundle\Security\UserProvider AS FOSUserProvider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class UserProvider extends FOSUserProvider
{
    /**
     * @var bool Stateless Authentication?
     */
    private $stateless = false;

    /**
     * @param $apiKey
     *
     * @return UserInterface
     */
    public function loadUserByApiKey($apiKey)
    {
        $this->stateless = true;

        return $this->userManager->findUserBy(array('apiKey' => $apiKey));
    }

    /**
     * @param SecurityUserInterface $user
     *
     * @return SecurityUserInterface
     * @throws UnsupportedUserException
     */
    public function refreshUser(SecurityUserInterface $user)
    {
        if ($this->stateless) {
            throw new UnsupportedUserException();
        }
        return parent::refreshUser($user);
    }
}
