<?php

namespace retItalia\AuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ret_italia_authentication');

        $rootNode
            ->children()
            ->arrayNode('parameters')
            ->children()
            ->scalarNode('google_client_id')->end()
            ->scalarNode('google_client_secret')->end()
            ->scalarNode('google_redirect_url')->end()
            ->scalarNode('application_id')->end()
            ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
