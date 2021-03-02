<?php

namespace QuizzBundle\Controller;

use QuizzBundle\Entity\User;
use QuizzBundle\Form\SearchFindType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuizzBundle\Entity\Produits;
use QuizzBundle\Form\ProduitsType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductsController extends Controller
{
    /**
     * @Route("/monProfil", name="mon_profil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function monProfilAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        // test à faire
        $produits = $em->getRepository(Produits::class)
            ->findProductsByUser($this->getUser());

        return $this->render('QuizzBundle:Default:profil.html.twig', array(
            'produits' => $produits
        ));
    }

    /**
     * @Route("/delete/{id}", name="product_delete")
     * @param Request $request
     * @param Produits $produits
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Produits $produits){
        //appel à la BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();

        $this->addFlash('success', "Votre élément vient d'être supprimé!");
        return $this->redirectToRoute('profil');
    }

    /**
     * @param Request $request
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
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $this->getUser();
            $produit->setUser($user);
            $em->persist($produit);
            $em->flush();
            //return new Response('produit add');
            return $this->redirectToRoute('homepage');
        }
        //génére html
        $formView = $form->createView();
        //render view
        return $this->render('QuizzBundle:Default:formAdd.html.twig',array(
            'form' => $formView
        ));
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
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
            'form'=>$formSearch->createView()
        ));
    }

    /**
     * @Route("/product/{id}", name="product_detail")
     * @ParamConverter("produits", class="QuizzBundle\Entity\Produits")
     * @param Request $request
     * @param Produits $produit
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function oneProduct(Request $request, Produits $produit){

//      Avant le param converter
//        $produit = $this->getDoctrine()
//            ->getRepository(Produits::class)
//            ->find($id);


        //if (!$produit) {
          //  throw $this->createNotFoundException(
          //      'No product found for id '.$id
          //  );}
        return $this->render('QuizzBundle:Default:oneArticle.html.twig',array(
            'produit'=>$produit
        ));
    }

}