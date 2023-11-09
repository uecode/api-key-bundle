<?php

namespace Uecode\Bundle\ApiKeyBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class ApiKeyFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.api_key.' . $id;
        $container->setDefinition($providerId, new DefinitionDecorator('uecode.api_key.provider.api_key'))
            ->replaceArgument(0, new Reference($userProvider));

        $listenerId = 'security.authentication.listener.api_key.' . $id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('uecode.api_key.listener.api_key'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'api_key';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
    }
}
