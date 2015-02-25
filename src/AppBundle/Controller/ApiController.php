<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/api/tags", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('Tag')->findAll();
    }
}
