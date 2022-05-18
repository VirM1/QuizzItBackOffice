<?php

namespace App\Controller\Api;

use App\Entity\Utilisateur;
use App\Manager\SerializerManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    public function __construct(private UserManager $userManager)
    {
    }

    #[Route('/getuserinfo', name: 'app_user_info',methods: ["GET"])]
    public function getUserInfo(SerializerManager $serializerManager): Response
    {
        try{
            $user = $this->getUser();
            if($user instanceof Utilisateur){
                $serialized = $serializerManager->serializeUser($user);
                $response =  new Response($serialized,JsonResponse::HTTP_OK);
                $response->headers->set("Content-Type","application/json");
                return $response;
            }else{
                return new JsonResponse(null,JsonResponse::HTTP_FORBIDDEN);
            }

        }catch(\Exception $exception){
            return new JsonResponse(null,JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/changeUserPassword', name: 'app_user_change_password',methods: ["POST"])]
    public function changeUserPassword(Request $request)
    {//todo : add passwordConstraints
        try{

            $user = $this->getUser();
            if($user instanceof Utilisateur){
                $data = $request->toArray();
                return $this->userManager->modifyUserPassword($user,$data);
            }else{
                return new JsonResponse(null,JsonResponse::HTTP_FORBIDDEN);
            }
        }catch(\Exception $exception){
            return new JsonResponse(null,JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/register', name: 'app_register_user',methods: ["POST"])]
    public function registerUser(Request $request){
        try{
            $data = $request->toArray();
            return $this->userManager->registerUser($data);
        }catch(\Exception $exception){
            return new JsonResponse(null,JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //todo @Virgile : route to delete user
}
