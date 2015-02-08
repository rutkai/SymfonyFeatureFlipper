<?php

namespace Rutkai\FeatureFlipperBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RutkaiFeatureFlipperExtension extends Extension {
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('rutkai_feature_flipper.enable_undefined_feature', $config['enable_undefined_feature']);
        $container->setParameter('rutkai_feature_flipper.expiration_warning', $config['expiration_warning']);
        $container->setParameter('rutkai_feature_flipper.feature_class', $config['feature_class']);
        $container->setParameter('rutkai_feature_flipper.template.warning_console', $config['template']['warning_console']);
        $container->setParameter('rutkai_feature_flipper.template.warning_email', $config['template']['warning_email']);
        $container->setParameter('rutkai_feature_flipper.template.alert_console', $config['template']['alert_console']);
        $container->setParameter('rutkai_feature_flipper.template.alert_email', $config['template']['alert_email']);
        $container->setParameter('rutkai_feature_flipper.email.from', $config['email']['from']);
        $container->setParameter('rutkai_feature_flipper.email.subject', $config['email']['subject']);
        $container->setParameter('rutkai_feature_flipper.features', $config['features']);
    }

}
