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


class RedirectController extends Controller
{

    /**
     * @param Request $request  the request object containing (among other things) the url
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginLogoutRedirectAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();

        $auth_array = array( 'login', 'logout' );

        foreach( $auth_array as &$auth )
            if( FALSE !== strpos( $pathInfo, $auth ) )
                 return $this->redirect($this->generateUrl('fb_' . $auth, array(), 301));

        unset( $auth );

        /* @TODO: Fix error message */
        throw $this->createNotFoundException('Login/Logout whatever problem');
    }
}