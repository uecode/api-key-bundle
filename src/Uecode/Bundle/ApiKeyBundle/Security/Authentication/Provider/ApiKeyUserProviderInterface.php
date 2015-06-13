<?php
namespace Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider;

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
