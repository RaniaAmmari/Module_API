<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiPostController extends AbstractController
{
    /**
     * @GET("/article", name="app_api_index")
     * 
     */
    public function index(ArticleRepository $ArticleRepository , SerializerInterface $serializer)
    {
        return   $this->json($ArticleRepository->findAll(),200 ,[]);
       
      
    }
    /**
     * @GET("/article/{id}", name="app_api_article", requirements = {"id"="\d+"})
     */
    public function articleId(ArticleRepository $ArticleRepository , SerializerInterface $serializer, int $id)
    
        {
            try
            {
            return   $this->json($ArticleRepository->find($id), 200 ,[]);
        } catch (NotEncodableValueException $e) {
           return $this->json ([
            'status' => 404,
           'message' => $e ->getMessage()
           ], 404 ,"l'Id est non trouvé");
        }
      
    }

    /**

 * @POST("/article", name="ajout")

 */

public function addArticle(Request $request,ManagerRegistry $doctrine)

{
        $article = new Article();
       $donnees = json_decode($request->getContent());

        $article->setTitle($donnees->title)

                ->setContent($donnees->content)

                ->setAutor($donnees->autor)

                ->setDate(new \DateTime());

        $entityManager = $doctrine->getManager();

        $entityManager->persist($article);

        $entityManager->flush();

        return $this->json($article,201,[]);

}
/**
 * @Put("/article/{id}", name="edit")
 */
public function editArticle( ?Article $article, Request $request ,ManagerRegistry $doctrine)
{
    $donnees = json_decode($request->getContent());

        $code = 200;
        if(!$article){
            $article = new Article();
            $code = 201;
        }
        else {
        $article->setTitle($donnees->title);

        $article->setContent($donnees->content);

        $article->setAutor($donnees->autor);

        $article ->setDate(new \DateTime());  

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->json($article,201,[]);}   
}
/**
 * @GET("/articles", name="find")
 */
public function find(ArticleRepository $ArticleRepository)
{
    return   $this->json($ArticleRepository->findBylast(),200 ,[]);

}
/**
 * @Delete("/article/{id}", name="delete")
 */
public function remove(Article $article)
{
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($article);
    $entityManager->flush();
    return $this->json($article,200,[]); 
}

}


