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
     * @Route("/login", name="fb_login")
     */
    public function loginAction()
    {
        return $this->render('FBAppBundle:Secured:login.html.twig');
    }
}