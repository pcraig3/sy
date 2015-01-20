<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 04:55
 */

namespace pcraig3\FBAppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecuredController extends Controller {

    /**
     * @TODO: http://inchoo.net/dev-talk/symfony-hwioauthbundle-and-google-sign-in/
         * @TODO: https://github.com/hwi/HWIOAuthBundle/blob/master/Resources/doc/3-configuring_the_security_layer.md
     *
     *  //sign in
     *  //print friends
     *  //create users
     */

    /**
     * @Route("/login", name="fb_login")
     */
    public function loginAction()
    {
        return $this->render('FBAppBundle:Secured:login.html.twig');
    }
}