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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*
 * @Route("/fb")
 */
class SecuredController extends Controller {

    /**
     * @TODO: http://inchoo.net/dev-talk/symfony-hwioauthbundle-and-google-sign-in/
     * @TODO: https://github.com/hwi/HWIOAuthBundle/blob/master/Resources/doc/3-configuring_the_security_layer.md
     *
     *
    /
    /privacy

    /fb/login
    /fb/logout

    /fb/user
    /fb/email
    /fb/user_friends
    /fb/friends_with

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


    /*
     * @Route("/login", name="fb_login")
     * @Template()
     *
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }
    */

    /**
     * @Route("/login/check-facebook", name="fb_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="fb_logout")
     */
    public function logoutAction()
    {
        $error = 0;
        // The security layer will intercept this request
    }

    /**
     * @Route("/hi", defaults={"name"="Paul"}),
     * @Route("/hi/{name}", name="fb_hello")
     */
    public function helloAction($name)
    {
        return $this->render('FBAppBundle:Secured:hello.html.twig', array(
            'name' => $name
        ));
    }

    /**
     * @Route("/hi/admin/{name}", name="fb_hello_admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function helloadminAction($name)
    {
        return $this->render('FBAppBundle:Secured:helloadmin.html.twig', array(
            'name' => $name
        ));    }
}