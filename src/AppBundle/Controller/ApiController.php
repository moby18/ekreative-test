<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @Route("/api/tags", name="api_tags")
     * @Method("GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function tagsAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("AppBundle:Tag")->findAll();
        return new JsonResponse($items);
    }
}
