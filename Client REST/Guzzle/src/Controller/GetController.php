<?php

namespace App\Controller;

 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
 
class GetController extends AbstractController
{
    /**
     * @Route("/postes", name="app_postes")
     */
    public function index(): Response
    {
  
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://jsonplaceholder.typicode.com',
]);
  
$response = $client->request('GET', '/posts');
if (200 == $response->getStatusCode()) { 
$body = $response->getBody();
$arr_body = json_decode($body);
// echo "<pre>"; print_r($arr_body);echo "<pre>";
var_dump ($response->getStatusCode());
return $this->render('get.html.twig', [
    'controller_name' => 'GetController',
        'postes' => $arr_body
]);
}}

/**
     * @Route("/ajout", name="app_ajout_poste")
     */
    public function ajout(): Response
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://jsonplaceholder.typicode.com',
        ]);
          
        $response = $client->request('Post', '/posts', [
            'json' => [
                 'userId'=> 2,
                    'id'=> 100,
                    'title'=> 'autem hic labore sunt dolores incidunt',
                    'body'=>'enim et ex nulla\nomnis voluptas quia qui\nvoluptatem consequatur numquam aliquam sunt\ntotam recusandae id dignissimos aut sed asperiores deserunt'
                  
            ]
        ]);
          
        //get status code using $response->getStatusCode();
        if (200 == $response->getStatusCode()) { 
        $body = $response->getBody();
        $arr_body = json_decode($body);
        // var_dump ($response->getStatusCode());
        // echo "<pre>"; print_r($arr_body);echo "<pre>";
        return $this->render('post.html.twig', [
                'post' => $arr_body]);
        }
}
/**
     * @Route("/delete", name="app_delete_poste")
     */
    public function delete() : Response
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://jsonplaceholder.typicode.com',
        ]);
          
        $response = $client->request('DELETE', '/posts/1');
        if (200 == $response->getStatusCode()) {  
        echo( $response->getStatusCode());
        return $this->render('delete.html.twig') ;}
}
}