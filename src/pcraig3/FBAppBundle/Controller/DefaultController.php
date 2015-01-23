<?php

namespace pcraig3\FBAppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="fb_index")
     */
    public function indexAction()
    {
        return $this->render('FBAppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/other", name="fb_other")
     */
    public function otherAction()
    {
        return $this->render('FBAppBundle:Default:other.html.twig');
    }
}
