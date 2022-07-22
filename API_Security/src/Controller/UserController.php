<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
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
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class UserController extends AbstractController
{
    /**
     * @GET("/user", name="get_user")
     * 
     */
    public function index(UserRepository $userRepository , SerializerInterface $serializer)
    { 

        return   $this->json($UserRepository->findAll(),200 ,[]);

    }
     /**

 * @POST("/user", name="ajout")

 */

public function addUser(Request $request, ManagerRegistry $doctrine , PasswordUpgraderInterface  $password)

{
    $user = new User();
       $donnees = json_decode($request->getContent());

        $user->setEmail($donnees->email)

                ->setRoles($donnees->role);

            
        $entityManager = $doctrine->getManager();

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json($user,201,[]);

}
}