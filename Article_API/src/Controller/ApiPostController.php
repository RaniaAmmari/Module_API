<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use FOS\RestBundle\Controller\Annotations\Get;

class ApiPostController extends AbstractController
{
    /**
     * @GET("/api/post", name="app_api_index")
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
}


