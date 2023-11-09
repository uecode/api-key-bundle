<?php

namespace Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Gennady Telegin <gtelegin@gmail.com>
 */
interface ApiKeyUserProviderInterface
{
    /**
     * @param string $apiKey
     *
     * @return UserInterface
     */
    public function loadUserByApiKey($apiKey);
}
