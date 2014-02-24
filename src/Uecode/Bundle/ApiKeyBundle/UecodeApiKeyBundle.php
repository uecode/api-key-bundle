<?php

namespace Uecode\Bundle\ApiKeyBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Uecode\Bundle\ApiKeyBundle\DependencyInjection\Security\Factory\ApiKeyFactory;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class UecodeApiKeyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new ApiKeyFactory());
    }
}
