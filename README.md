Advanced Feature Flipper (toggle) for Symfony2
==============================================

This bundle provides a feature flipper interface for Symfony2. (Planned) Main features:

- Feature checks in twigs and controllers (via DI)
- Assigning expiration date to features
- Assigning responsible people to features

Note: This bundle is not yet available through Composer as it is currently in development!

Usage
-----

# Configuration

    # config.yml
    
    feature:
        features:
            feature_id:
                name: feature_id
                enabled: true
                expiration: 2015-03-03 12:00:00
                responsible: "András Rutkai"
                responsible_email: email@domain.com
            feature_id_2:
                name: feature_id_2
                enabled: false
                expiration: ~   # no expiration
                responsible: ~  # no responsible

# Twig

    {% if feature_enabled("feature_id") %}
        ...
    {% endif %}
    
# Controller or services

    $featureManager = $this->get('feature.manager');
    if ($featureManager->isEnabled("feature_id"))
        ...

Roadmap
-------

* 1.0.0: YML/XML based configuration, notifications using e-mail
* 1.1.0: Doctrine backend for storing features
* 1.2.0: Redis backend for storing features