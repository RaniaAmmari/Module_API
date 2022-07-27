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
     *  @Rest\View(serializerGroups={"article"})
     *  @Rest\Get("/article")
     */
    public function index(ArticleRepository $ArticleRepository , SerializerInterface $serializer)
    { 

        return $ArticleRepository->findAll();

    }
    /**
     *  @Rest\View(serializerGroups={"article"})
     * @Rest\Get("/api/article/{id}", name="app_api_article", requirements = {"id"="\d+"})
     */
    public function articleId(ArticleRepository $ArticleRepository , SerializerInterface $serializer, int $id)
    
        {
           if ($ArticleRepository->find($id) == true){
            return   $ArticleRepository->find($id);
        } else {
           return $this->json ([
            'status' => 404,
           'message'=> 'article non existant'
           ], 404 );
        }
      
    }  

    /**
     * @Rest\View(serializerGroups={"article"})
     * @Rest\Post("/api/article")
     */
    public function addArticle(Request $request,ManagerRegistry $doctrine,SerializerInterface $serializer)

    {
        
        try {
            $article = $serializer->deserialize($request->getContent(),Article::class,'json');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
             return $this->json ([
                'status' => 201,
               'message'=> 'article cree'
               ], 201 );
        } catch (NotEncodableValueException $e) {
            return $this->json(["error message"=>$e->getMessage()],400);
        }

    }

/**
 *  @Rest\View(serializerGroups={"article"})
 *  @Rest\Get("api/article/trois")
 */
public function find(ArticleRepository $ArticleRepository)
{
    return  $ArticleRepository->findBylast();

}
/**
 *  @Rest\View(serializerGroups={"article"})
 *  @Rest\Put("api/article/{id?}")
 */
public function editArticle( Article $article, Request $request ,ManagerRegistry $doctrine ,SerializerInterface $serializer,ArticleRepository $ArticleRepositor,$id=null):Response
{
   
        $content = $serializer->deserialize($request->getContent(),Article::class,'json');

        if($id){
            $article = $ArticleRepository->find($id);
            if(!$article){
                return $this->json(["error message" => "article not found"],404);
            }
            $article->setTitle($content->getTitle());
            $article->setContent($content->getContent());
            $article->setAutor($content->getAutor());
            $article->setDate($content->getDate());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->json($article,200);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($content);
        $entityManager->flush();
        return $this->json($content,201);

}

/**
 *@Rest\View(serializerGroups={"article"})
 *@Rest\Delete("api/article/{id}")
 */
public function remove(Article $article)
{
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($article);
    $entityManager->flush();
    return $this->json($article,200,[]);

}
}


