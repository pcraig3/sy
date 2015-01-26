<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 25/01/2015
 * Time: 21:40
 */

namespace pcraig3\FBAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class RedirectController extends Controller
{

    /**
     * @Route(
     *       path         = "/{url}",
     *       name         = "redirect_to_proper_login_page",
     *       requirements = { "url" = ".*login(?!\/check).*" },
     *       methods      =  "GET" ,
     * )
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginRedirectAction(Request $request)
    {
        $req = $request;
        return $this->redirect($this->generateUrl('fb_login', array(), 301));
    }

    public function logoutRedirectAction()
    {
        return $this->redirect($this->generateUrl('fb_logout', array(), 301));
    }
}