<?php

namespace Uecode\Bundle\ApiKeyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class UecodeApiKeyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $this->defineKeyExtractor($config, $container);
    }

    private function defineKeyExtractor(array $config, ContainerBuilder $container)
    {
        $container->setParameter('uecode.api_key.parameter_name', $config['parameter_name']);
        $container->setAlias('uecode.api_key.extractor', 'uecode.api_key.extractor.'.$config['delivery']);
    }
}

