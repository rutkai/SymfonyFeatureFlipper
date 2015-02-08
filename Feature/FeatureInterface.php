<?php

namespace Rutkai\FeatureFlipperBundle\Feature;

/**
 * Interface FeatureInterface
 *
 * @package Rutkai\FeatureFlipperBundle\Feature
 * @author András Rutkai
 */
interface FeatureInterface {

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return boolean
     */
    public function isEnabled();

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled);

    /**
     * @return \DateTime
     */
    public function getExpiration();

    /**
     * @param \DateTime $expiration
     * @return $this
     */
    public function setExpiration(\DateTime $expiration = null);

    /**
     * @return string
     */
    public function getResponsible();

    /**
     * @param string $responsible
     * @return $this
     */
    public function setResponsible($responsible = null);

    /**
     * @return string
     */
    public function getResponsibleEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setResponsibleEmail($email = null);

}