<?php
/**
 * @author    Aaron Scherer
 * @date      January 3, 2014
 * @copyright Underground Elephant
 */
namespace Uecode\Bundle\ApiKeyBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uecode\Bundle\ApiKeyBundle\DependencyInjection\Security\Factory\ApiKeyFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;

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

