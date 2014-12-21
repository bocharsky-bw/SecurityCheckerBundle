SecurityCheckerBundle
=====================

Security Checker wrapper for Symfony Web Debug Toolbar.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/be002c6e-4d7c-4a96-8348-4407a7d3cf7c/mini.png)](https://insight.sensiolabs.com/projects/be002c6e-4d7c-4a96-8348-4407a7d3cf7c)

![BW Security Checker](/Resources/images/bw-security-checker-review.jpg)

Install
-------

Install bundle with `Composer` dependency manager first by running the command:

`$ composer require "bocharsky-bw/security-checker-bundle:dev-master"`

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
    resource: "@BWSecurityCheckerBundle/Resources/config/routing.yml"
    prefix:   /_bw
```

Congratulations!
----------------
You're ready to check your `Symfony` project for known* security issues by easiest way!

\* *Disclaimer:* This checker can only detect vulnerabilities that are referenced in the [SensioLabs](https://security.sensiolabs.org/) security advisories database.
