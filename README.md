SecurityCheckerBundle
=====================

Security Checker wrapper for Symfony Web Debug Toolbar.

Install
-------

Install bundle with `Composer` dependency manager first by running the command:

`$ php composer.phar require "bocharsky-bw/security-checker-bundle:dev-master"`

`Composer` will install the bundle to your project's `vendor` directory.

Include
-------

Including the bundle to your `Symfony` project is as easy as to do a few simple steps.

1) Enable the bundle in application kernel for `dev` environment:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    // other bundles...
    
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        // other dev bundles...
        $bundles[] = new BW\SecurityCheckerBundle\BWSecurityCheckerBundle();
    }
}
```

2) Register the bundle's routes for `dev` environment:

``` yaml
# app/config/routing_dev.yml
_bw_security_checker:
    resource: "@BWSecurityCheckerBundle/Controller/"
    type:     annotation
```

Congratulations!
----------------
You're ready to check your `Symfony` project for known* security issues by easiest way!

\* *Disclaimer:* This checker can only detect vulnerabilities that are referenced in the [SensioLabs](https://security.sensiolabs.org/) security advisories database.
