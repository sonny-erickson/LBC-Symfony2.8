<?php

namespace QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuizzBundle:Default:index.html.twig');
        
    }
    
    public function signInAction()
    {
        return $this->render('QuizzBundle:Default:signIn.html.twig');
        
    }
    
    public function oneArticleAction()
    {
        return $this->render('QuizzBundle:Default:oneArticle.html.twig');
        
    }
    
    public function registerAction()
    {
        return $this->render('QuizzBundle:Default:register.html.twig');
        
    }
}
