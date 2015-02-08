<?php

namespace Rutkai\FeatureFlipperBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('feature');

        $rootNode
            ->children()
                ->booleanNode('enable_undefined_feature')->defaultTrue()->end()
                ->integerNode('expiration_warning')->defaultValue(7)->end()
                ->scalarNode('feature_class')->defaultValue(7)->end()
                ->arrayNode('features')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('enabled')->isRequired()->defaultTrue()->end()
                            ->scalarNode('expiration')->end()
                            ->scalarNode('responsible')->end()
                            ->scalarNode('responsible_email')->end()
                        ->end()
                    ->end() // feature
                ->end() // features
            ->end();

        return $treeBuilder;
    }
}
