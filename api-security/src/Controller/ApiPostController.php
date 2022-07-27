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
use FOS\RestBundle\Controller\Annotations as Rest;



class ApiPostController extends AbstractController
{
    /**
     *  @Rest\Get("/article")
     */
    public function index(ArticleRepository $ArticleRepository , SerializerInterface $serializer)
    { 

        return   $this->json($ArticleRepository->findAll(),200 ,[],['groups'=>'article']);

    }
    /**
     * @Rest\Get("/api/article/{id}", name="app_api_article", requirements = {"id"="\d+"})
     */
    public function articleId(ArticleRepository $ArticleRepository , SerializerInterface $serializer, int $id)
    
        {
           if ($ArticleRepository->find($id) == true){
            return   $this->json($ArticleRepository->find($id), 200 ,[],['groups'=>'article']);
        } else {
           return $this->json ([
            'status' => 404,
           'message'=> 'article non existant'
           ], 404 );
        }
      
    }  

    /**
     * @Rest\Post("/api/article")
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
 *  @Rest\Get("api/article/trois")
 */
public function find(ArticleRepository $ArticleRepository)
{
    return   $this->json($ArticleRepository->findBylast(),200 ,[],['groups'=>'article']);

}
/**
 *  @Rest\Put("api/article/{?id}")
 */
public function editArticle( ?Article $article, Request $request ,ManagerRegistry $doctrine)
{
    $donnees = json_decode($request->getContent());

       
    if(!$article)
        {
            $article = new Article();
            $code=200;
        }
        
        $article->setTitle($donnees->title);

        $article->setContent($donnees->content);

        $article->setAutor($donnees->autor);

        $article ->setDate(new \DateTime()); 

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->json($article,201,[]);
    

}

/**
 *@Rest\Delete("api/article/{id}")
 */
public function remove(Article $article)
{
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($article);
    $entityManager->flush();
    return $this->json($article,200,[],['groups'=>'article']); 
}

}


