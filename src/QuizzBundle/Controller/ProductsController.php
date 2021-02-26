<?php

namespace QuizzBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use QuizzBundle\Data\SearchData;
use QuizzBundle\Form\ProduitsSearchType;
use QuizzBundle\Form\SearchFindType;
use QuizzBundle\Repository\ProduitsRepository;
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
            ->findProductsByUser($this->getUser()); //test à faire
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
    public function searchAction(Request $request){
        $formSearch = $this->createForm(SearchFindType::class);
        $em = $this->getDoctrine()->getManager();

        $produitsRepo = $em->getRepository(Produits::class);

        $produits = $produitsRepo
            ->findAll();

        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $data = $formSearch->getData();
            $produits = $produitsRepo
                ->findSearch($data);
        }

        return $this->render('QuizzBundle:Default:index.html.twig',array(
            'produits'=>$produits,
            'form'=>$formSearch->createView()));
    }

    /**
     * @Route("/oneProduct", name="oneProduct")
     */
    public function oneProduct(){
        return $this->render('QuizzBundle:Default:oneArticle.html.twig');
    }

}