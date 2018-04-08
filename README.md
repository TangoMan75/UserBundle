TangoMan User Bundle
====================

**TangoMan User Bundle** provides basis for user management.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require tangoman/user-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new TangoMan\UserBundle\TangoManUserBundle(),
        );

        // ...
    }
}
```

Step 3: Configure UserBundle routes
-----------------------------------

Enable UserBundle controllers by adding following code in the `app/config/routing.yml` file of your project.

```yaml
tangoman_user:
    resource: "@TangoManUserBundle/Controller/"
    type:     annotation
```

Step 4: Configure Symfony firewall
----------------------------------

Enable UserBundle to handle user login/logout by adding following code in the `app/config/security.yml` file of your project.

```yaml
security:
    firewalls:
        admin:
            anonymous: ~
            provider: database
            pattern: ^/
            form_login:
                login_path: app_login
                check_path: app_check
                default_target_path: homepage
            logout:
                path: app_logout
                target: homepage
                invalidate_session: true
```

Step 5: Configure UserBundle parameters
---------------------------------------

UserBundle need these settings to handle user registration, password reset emails.

Add following code in the `app/config/parameters.yml` file of your project.

```yaml
parameters:
    site_name:   "FooBar"
    site_author: "TangoMan"
    mailer_from: "tangoman@localhost.dev"
```

Step 6: Update Twig Configuration
---------------------------------

Enable twig to handle global variables by adding following code in the `app/config/config.yml` file of your project.

```yaml
# Twig Configuration
twig:
    globals:
        site_name:   "%site_name%"
        site_author: "%site_author%"
        mailer_from: "%mailer_from%"
```

Step 7: Create User entity
--------------------------

Your User entity must extend `TangoMan\UserBundle\Model\User` class.

Your User entity must implement `getRoles()` method.

```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TangoMan\UserBundle\Model\User as TangoManUser;

/**
 * Class User
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends TangoManUser
{
    // ...

    private $roles;

    public function __construct()
    {
        parent::__construct();
        // ...
    }

    public function getRoles()
    {
        return $this->roles;
    }

}
```

Step 8: Base template
---------------------

Your base template must be named as the following : `base.html.twig`

Note
====

If you find any bug please report here : [Issues](https://github.com/TangoMan75/UserBundle/issues/new)

License
=======

Copyright (c) 2018 Matthias Morin

[![License][license-MIT]][license-url]
Distributed under the MIT license.

If you like **TangoMan User Bundle** please star!
And follow me on GitHub: [TangoMan75](https://github.com/TangoMan75)
... And check my other cool projects.

[Matthias Morin | LinkedIn](https://www.linkedin.com/in/morinmatthias)

[license-MIT]: https://img.shields.io/badge/Licence-MIT-green.svg
[license-url]: LICENSE
