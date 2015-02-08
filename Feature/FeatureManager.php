<?php

namespace Rutkai\FeatureFlipperBundle\Feature;

use Rutkai\FeatureFlipperBundle\Exception\FeatureNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FeatureManager
 * @package Rutkai\FeatureFlipperBundle\Feature
 * @author András Rutkai
 */
class FeatureManager implements \IteratorAggregate {

    /**
     * @var array
     */
    protected $features = array();

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;

        $this->loadFeaturesFromConfig($container);
    }

    /**
     * @param FeatureInterface $feature
     */
    public function addFeature(FeatureInterface $feature) {
        $this->features[$feature->getName()] = $feature;
    }

    /**
     * @param string $feature
     * @return bool
     * @throws FeatureNotFoundException
     */
    public function isEnabled($feature) {
        if (!$this->hasFeature($feature)) {
            return $this->container->getParameter('rutkai_feature_flipper.enable_undefined_feature');
        }

        return $this->getFeature($feature)->isEnabled();
    }

    /**
     * @param string $feature
     * @return bool
     */
    public function hasFeature($feature) {
        return array_key_exists($feature, $this->features);
    }

    /**
     * @param string $feature
     * @return FeatureInterface
     * @throws FeatureNotFoundException
     */
    public function getFeature($feature) {
        if (!$this->hasFeature($feature)) {
            throw new FeatureNotFoundException();
        }

        return $this->features[$feature];
    }

    /**
     * @inheritdoc
     */
    public function getIterator() {
        return new \ArrayIterator($this->features);
    }

    /**
     * @param ContainerInterface $container
     */
    protected function loadFeaturesFromConfig(ContainerInterface $container) {
        $featureClass = $container->getParameter('rutkai_feature_flipper.feature_class');
        foreach ($this->container->getParameter('rutkai_feature_flipper.features') as $name => $options) {
            $feature = new $featureClass();
            $feature->setName($name);
            $feature->setEnabled($options['enabled']);
            $feature->setExpiration($options['expiration'] ? new \DateTime($options['expiration']) : null);
            $feature->setResponsible($options['responsible']);
            $feature->setResponsibleEmail($options['responsible_email']);

            $this->addFeature($feature);
        }
    }

}
