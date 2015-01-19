<?php

namespace pcraig3\FBAppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="fb_home")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/login", name="fb_login")
     */
    public function loginAction()
    {
        return $this->render('FBAppBundle:Default:login.html.twig');
    }
}
