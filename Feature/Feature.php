<?php

namespace Rutkai\FeatureFlipperBundle\Feature;

/**
 * Class Feature
 * @package Rutkai\FeatureFlipperBundle\Feature
 * @author András Rutkai
 */
class Feature implements FeatureInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var \DateTime
     */
    protected $expiration;

    /**
     * @var
     */
    protected $responsible;


    /**
     * @inheritdoc
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * @inheritdoc
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getExpiration() {
        return $this->expiration;
    }

    /**
     * @inheritdoc
     */
    public function setExpiration(\DateTime $expiration) {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResponsible() {
        return $this->responsible;
    }

    /**
     * @inheritdoc
     */
    public function setResponsible($responsible) {
        $this->responsible = $responsible;

        return $this;
    }

}