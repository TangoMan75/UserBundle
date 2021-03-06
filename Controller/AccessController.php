<?php
/**
 * Copyright (c) 2018 Matthias Morin <matthias.morin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TangoMan\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccessController extends Controller
{

    /**
     * Build login form.
     * @Route("/login", name="app_login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');
        $error  = $helper->getLastAuthenticationError();

        if ($error) {
            $this->get('session')->getFlashBag()->add('error', $error);
            $this->get('session')->getFlashBag()->add('translate', 'true');
        }

        return $this->render(
            '@TangoManUser/default/login.html.twig',
            [
                'lastUsername' => $helper->getLastUsername(),
            ]
        );
    }

    /**
     * Abstract method required by symfony core.
     * @Route("/logout", name="app_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * Abstract method required by symfony core.
     * @Route("/check", name="app_check")
     */
    public function checkAction()
    {
    }
}
