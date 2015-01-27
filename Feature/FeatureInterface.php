<?php

namespace Rutkai\FeatureFlipperBundle\Feature;

/**
 * Interface FeatureInterface
 *
 * @package Rutkai\FeatureFlipperBundle\Feature
 * @author András Rutkai
 */
interface FeatureInterface {

    public function isEnabled();

    public function getExpiration();

    public function getAuthor();

}