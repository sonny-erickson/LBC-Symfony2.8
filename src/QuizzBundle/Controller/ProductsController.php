<?php

namespace QuizzBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuizzBundle\Entity\Produits;
use QuizzBundle\Form\ProduitsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductsController extends Controller{

    /**
     * @Route("/mon_profil", name="profil")
     */
    public function profile(){
        //appel à la BDD
        $em = $this->getDoctrine()->getManager();
        $produits =$em->getRepository('QuizzBundle:Produits')
            ->findProductsByUser();
        dump($produits);
        return $this->render('QuizzBundle:Default:profil.html.twig',array('produits'=>$produits));
    }

    /**
     * @Route("/delete/{id}", name="product_delete")
     */
    public function delete(Produits $produits){
        //appel à la BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();

        $this->addFlash('success', "Votre élément vient d'être supprimé!");
        return $this->redirectToRoute('profil');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("add", name="add_annonce")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function addProductAction(Request $request){
        //crée nouveau produit
        $produit = New Produits();

        // récup form
        $form = $this->createForm(ProduitsType::class,$produit);

        $form->handleRequest($request);


        //si form est soumis

        if($form->isSubmitted() && $form->isValid()){
            //on save
            $em=$this->getDoctrine()->getManager();
            $produit->setUser($this->getUser());// récup le current user
            $em->persist($produit);
            $em->flush();

            //return new Response('produit add');
            return $this->redirectToRoute('homepage');
        }

        //génére html
        $formView = $form->createView();

        //render view
        return $this->render('QuizzBundle:Default:formAdd.html.twig',array('form'=>$formView));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function findLastHomeAction(){
        //appel à la BDD
        $em = $this->getDoctrine()->getManager();

        // $produit = new Produits();
        // $produit->setCategories('Transport');
        // $produit->setDescription('Va super vite !!');
        // $produit->setNom('Vélo à Roulette');
        // $produit->setPrix('250');
        // $produit->setImage('https://www.numerama.com/content/uploads/2019/05/test-velo-mad-in-france-1.jpg');
        // // garde en mémoire
        //$em->persist($produit);
        // insére dans la BDD
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
        $produits =$em
                        ->getRepository('QuizzBundle:Produits')
                        ->getLastProducts();

        return $this->render('QuizzBundle:Default:index.html.twig',array('produits'=>$produits));
    }
}