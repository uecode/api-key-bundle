<?php
namespace Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider;

use FOS\UserBundle\Security\EmailUserProvider as FOSUserProvider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class EmailUserProvider extends FOSUserProvider implements ApiKeyUserProviderInterface
{
    /**
     * @var bool Stateless Authentication?
     */
    private $stateless = false;

    /**
     * {@inheritdoc}
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
