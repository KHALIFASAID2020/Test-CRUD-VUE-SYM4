<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Produit;
class ProduitController extends AbstractController
{
    /**
     * Lists all Articles.
     * @FOSRest\Get("/produits")
     *
     * @return array
     */
    public function getArticleAction()
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        
        // query for a single Product by its primary key (usually "id")
        $articles = $repository->findall();
        //$_article=[];
        //$_articles=[];
        foreach ($articles as $article) {
            $_article['id']=$article->getId();
            $_article['name']=$article->getName();
            $_article['description']=$article->getDescription(); 
            $_articles[]=$_article;
       }

      // return View::create($article, Response::HTTP_OK , []);
        return new JsonResponse($_articles,200);


//        return View::create($article, Response::HTTP_OK , []);
    }





    /**
     * Create Article.
     * @FOSRest\Post("/produit")
     *
     * @return array
     */
    public function postArticleAction(Request $request)
    {
        $produit = new Produit();
        $produit->setName($request->get('name'));
        $produit->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        //return View::create($article, Response::HTTP_CREATED , []);
        return new JsonResponse($produit,201);

    }
    /**
     * Update Produit.
     * @FOSRest\Put("/produit/{id}")
     *
     * @return array
     */
    public function UpdateArticleAction(Request $request,$id)
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);

       // $article = new Article();
        $produit->setName($request->get('name'));
        $produit->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        //return View::create($article, Response::HTTP_CREATED , []);
        return new JsonResponse($produit,201);

    }

    /**
     * Delete Produit.
     * @FOSRest\Delete("/produit/{id}")
     *
     * @return array
     */
    public function DeleteArticleAction(Request $request,$id)
    {
        $del = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $del->remove($produit);
        $del->flush();
            
        //return View::create($article, Response::HTTP_CREATED , []);
       return new JsonResponse('Article Deleted',200);

    }

}
