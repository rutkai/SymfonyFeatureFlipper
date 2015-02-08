<?php

namespace Rutkai\FeatureFlipperBundle\Twig;

use Rutkai\FeatureFlipperBundle\Feature\FeatureManager;

/**
 * Class FeatureExtension
 * @package Rutkai\FeatureFlipperBundle\Twig
 * @author András Rutkai
 */
class FeatureExtension extends \Twig_Extension {

    /**
     * @var FeatureManager
     */
    private $featureManager;

    /**
     * @inheritdoc
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('feature_enabled', array($this, 'featureEnabled')),
            new \Twig_SimpleFunction('has_feature', array($this, 'hasFeature')),
        );
    }

    /**
     * @inheritdoc
     */
    public function getName() {
        return 'feature_extension';
    }

    /**
     * @param FeatureManager $featureManager
     */
    public function __construct(FeatureManager $featureManager) {
        $this->featureManager = $featureManager;
    }

    /**
     * @param string $feature
     * @return bool
     */
    public function featureEnabled($feature) {
        return $this->featureManager->isEnabled($feature);
    }

    /**
     * @param string $feature
     * @return bool
     */
    public function hasFeature($feature) {
        return $this->featureManager->hasFeature($feature);
    }

}