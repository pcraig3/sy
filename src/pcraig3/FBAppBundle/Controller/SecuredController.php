<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 04:55
 */

namespace pcraig3\FBAppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/fb")
 */
class SecuredController extends Controller {

    /**
     * @TODO: get something AJAX back from Facebook, rather than just yourself
     * @TODO: Routes in a routing.yml file in this controller
     * @TODO: fix the route prefix
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
        ));
    }

    /**
     */

    /**
     * @Route("/user", name="fb_user")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction(Request $request)
    {
        $response = $request->getSession()->get('response');

        $name = $response['name'];

        return $this->render('FBAppBundle:Secured:user.html.twig', array(
            'name' => $name,
            'response' => $response
        ));
    }

    /**
     * @Route("/ajax", name ="fb_ajax_get")
     * @Method("GET")
     */
    public function ajaxGetAction()
    {
        return $this->render('FBAppBundle:Secured:ajax.html.twig', array(
            'name' => 'Nothing',
            'response' => array()
        ));
    }

    /**
     * @Route("/ajax", name ="fb_ajax_post")
     * @Method("POST")
     */
    public function ajaxPostAction()
    {
        $request = $this->container->get('request');
        $post_value = $request->request->get('data', 'Nothing received');

        if( is_numeric( $post_value ) ) {

            $dt = new \DateTime();
            $dt->setTimestamp($post_value);
            $post_value = $dt->format('H:i:s');
        }


        $response_content = array(
            "responseCode" =>   200,
            "success" =>        1,
            "message" =>        $post_value,
        );

        return new Response(
            json_encode($response_content),
            200,
            array('Content-Type'=>'application/json')
        );
    }
}
