<?php

namespace QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuizzBundle\Entity\Produits;

class ProductsController extends Controller{

    public function addAction(){
        //appel à la BDD
        $em = $this->getDoctrine()->getManager();

        // $produit = new Produits();
        // $produit->setCategories('Transport');
        // $produit->setDescription('Va super vite !!');
        // $produit->setNom('Vélo à Roulette');
        // $produit->setPrix('250');
        // $produit->setImage('https://www.numerama.com/content/uploads/2019/05/test-velo-mad-in-france-1.jpg');
        // // garde en mémoire
        // $em->persist($produit);
        // // insére dans la BDD
        // $produit2 = new Produits();
        // $produit2->setCategories('console');
        // $produit2->setDescription('Pas chère !!');
        // $produit2->setNom('Playstation2');
        // $produit2->setPrix('45');
        // $produit2->setImage('https://upload.wikimedia.org/wikipedia/commons/3/39/PS2-Versions.png');
        // // garde en mémoire
        // $em->persist($produit2);
        // // insére dans la BDD
        // $em->flush();
        $produits =$em->getRepository('QuizzBundle:Produits')->findAll();

        return $this->render('QuizzBundle:Default:index.html.twig',array('produits'=>$produits));
    }
}