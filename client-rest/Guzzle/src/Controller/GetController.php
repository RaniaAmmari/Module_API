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
    'base_uri' => 'http://127.0.0.1:8000/',
]);
  
$response = $client->request('GET', '/article');
if (200 == $response->getStatusCode()) { 
$body = $response->getBody();
$arr_body = json_decode($body);
// echo "<pre>"; print_r($arr_body);echo "<pre>";
// var_dump ($response->getStatusCode());
return $this->render('get.html.twig', [
    'controller_name' => 'GetController',
        'postes' => $arr_body
]);
}}

/**
     * @Route("/ajout", name="app_ajout_poste")
     */
    public function add(): Response
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://127.0.0.1:8000/',
        ]);
          
        $response = $client->request('Post', '/article', [
            'json' => [
                 
                    'title'=> 'autem hic labore sunt dolores incidunt',
                    'body'=>'enim et ex nulla\nomnis voluptas quia qui\nvoluptatem consequatur numquam aliquam sunt\ntotam recusandae id dignissimos aut sed asperiores deserunt',
                    'autor'=> 'autem  incidunt',
                    'date'=> '2022-07-21T18:03:46+02:00',

                  
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
     * @Route("/patch", name="app_patch_poste")
     */
    public function modifie() : Response
    {
$client = new Client([
    'base_uri' => 'https://jsonplaceholder.typicode.com',
]);
  
$response = $client->request('PATCH', '/posts/1', [
    'json' => [
        'title' => 'This title suits me very well',
    ]
]);
if (200 == $response->getStatusCode()) { 
$body = $response->getBody();
$arr_body = json_decode($body);
echo ($response->getStatusCode());
// print_r($arr_body);
return $this->render('modif.html.twig',[
    'modif' => $arr_body]);}
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