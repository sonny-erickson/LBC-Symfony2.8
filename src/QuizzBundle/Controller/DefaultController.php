<?php

namespace QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('QuizzBundle:Default:index.html.twig');
        
    }
    public function oneArticleAction()
    {
        return $this->render('QuizzBundle:Default:oneArticle.html.twig');
        
    }

}
