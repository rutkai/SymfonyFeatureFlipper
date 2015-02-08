Advanced Feature Flipper (toggle) for Symfony2
==============================================

This bundle provides a feature flipper interface for Symfony2. Main features:

- Feature checks in twigs and controllers (via DI)
- Assigning expiration date to features
- Assigning responsible people to features

Installation
------------

Add this bundle to `composer.json` file:

    "require": {
        ...
        "rutkai/featureflipperbundle": "dev-master"
    },

Register it in AppKernel:

    $bundles = array(
        ...
        new Rutkai\FeatureFlipperBundle\RutkaiFeatureFlipperBundle(),
    );

Usage
-----

### Configuration

    # config.yml
    
    rutkai_feature_flipper:
        enable_undefined_feature: true  # Optional, sets the default strategy for undefined features
        expiration_warning: 7           # Optional, expiration e-mails will be sent to responsibles if expiration occurs within the next x days
        feature_class: Rutkai\FeatureFlipperBundle\Feature\Feature  # Optional, default feature container, must implement FeatureInterface
        templates:
            warning_console: RutkaiFeatureFlipperBundle:FeatureCheck:warning.txt.twig # Optional, output warning template for feature check command
            warning_email: RutkaiFeatureFlipperBundle:FeatureCheck:warning.txt.twig   # Optional, e-mail warning template for feature check command
            alert_console: RutkaiFeatureFlipperBundle:FeatureCheck:alert.txt.twig     # Optional, output alert template for feature check command
            alert_email: RutkaiFeatureFlipperBundle:FeatureCheck:alert.txt.twig       # Optional, e-mail alert template for feature check command
        email:
            from: architect@example.com # Required, sender of the warning
            subject: Expired feature    # Optional, subject for the warnings
        features:
            feature_id:
                enabled: true                       # Required
                expiration: "2015-03-03 12:00:00"   # Optional
                responsible: "András Rutkai"        # Optional
                responsible_email: email@domain.com # Optional
            feature_id_2:
                enabled: false
                expiration: ~   # no expiration
                responsible: ~  # no responsible

### Twig

    {% if feature_enabled("feature_id") %}
        ...
    {% endif %}

Twig functions:

* `feature_enabled('feature_id')`
* `has_feature('feature_id')`
    
### Controller or services

    $featureManager = $this->get('feature.manager');
    if ($featureManager->isEnabled("feature_id"))
        ...

Feature manager functions:

* `$featureManager->isEnabled('feature_id')`
* `$featureManager->hasFeature('feature_id')`
* `$featureManager->getFeature('feature_id')`
* `$featureManager->addFeature($feature)` where `$feature` implements `FeatureInterface` 

Roadmap
-------

* 1.0.0: YML/XML based configuration, notifications using e-mail
* 1.1.0: Doctrine backend for storing features
* 1.2.0: Redis backend for storing features