TangoMan User Bundle
====================

**TangoMan User Bundle** provides basis for user management.


How to install
--------------

With composer

```console
$ composer require tangoman/user-bundle
```


Enable the bundle
-----------------

Don't forget to enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new TangoMan\UserBundle\TangoManUserBundle(),
    );
}
```


Create your User entity
-----------------------

Don't forget to implement user roles.

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


Configure UserBundle routes
---------------------------

Inside your routing.yml

```yaml
tangoman_user:
    resource: "@TangoManUserBundle/Controller/"
    type:     annotation
```


Configure UserBundle firewall
-----------------------------

Inside your security.yml

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


Note
====

If you find any bug please report here : [Issues](https://github.com/TangoMan75/RepositoryHelper/issues/new)

License
=======

Copyrights (c) 2017 Matthias Morin

[![License][license-GPL]][license-url]
Distributed under the GPLv3.0 license.

If you like **TangoMan User Bundle** please star!
And follow me on GitHub: [TangoMan75](https://github.com/TangoMan75)
... And check my other cool projects.

[tangoman.free.fr](http://tangoman.free.fr)

[license-GPL]: https://img.shields.io/badge/Licence-GPLv3.0-green.svg
[license-MIT]: https://img.shields.io/badge/Licence-MIT-green.svg
[license-url]: LICENSE
