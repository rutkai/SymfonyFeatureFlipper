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
                ->scalarNode('feature_class')->defaultValue('Rutkai\FeatureFlipperBundle\Feature\Feature')->end()
                ->arrayNode('template')
                    ->children()
                        ->scalarNode('warning_console')->defaultValue('RutkaiFeatureFlipperBundle:FeatureCheck:warning.txt.twig')->end()
                        ->scalarNode('warning_email')->defaultValue('RutkaiFeatureFlipperBundle:FeatureCheck:warning.txt.twig')->end()
                        ->scalarNode('alert_console')->defaultValue('RutkaiFeatureFlipperBundle:FeatureCheck:alert.txt.twig')->end()
                        ->scalarNode('alert_email')->defaultValue('RutkaiFeatureFlipperBundle:FeatureCheck:alert.txt.twig')->end()
                    ->end()
                ->end() // template
                ->arrayNode('email')
                    ->children()
                        ->scalarNode('from')->isRequired()->end()
                        ->scalarNode('subject')->defaultValue('Expired feature')->end()
                    ->end()
                ->end() // email
                ->arrayNode('features')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('enabled')->isRequired()->defaultTrue()->end()
                            ->scalarNode('expiration')->defaultNull()->end()
                            ->scalarNode('responsible')->defaultNull()->end()
                            ->scalarNode('responsible_email')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end() // features
            ->end();

        return $treeBuilder;
    }
}
