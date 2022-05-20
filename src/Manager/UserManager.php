<?php

namespace App\Manager;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager {

    public const REQUIRED_PASSWORD = array("old_password","new_password","new_password_confirm");
    public const REQUIRED_USER = array("email","password","password_confirm","nom","prenom");

    public function __construct(private UserPasswordHasherInterface $passwordHasher,private EntityManagerInterface $entityManager)
    {
    }

    public function modifyUserPassword(Utilisateur $user,array $data): Response
    {
        if($this->validateKeys($data,self::REQUIRED_PASSWORD)){
            $oldPassword = $data["old_password"];
            $newPassword = $data["new_password"];
            $newPasswordConfirm = $data["new_password_confirm"];
            $check = $this->passwordHasher->isPasswordValid($user,$oldPassword);
            if($newPassword === $newPasswordConfirm
                && $check)
            {
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $user,
                    $newPassword
                );
                $user->setPassword($hashedPassword);
                $this->entityManager->flush();
                return new JsonResponse(null,JsonResponse::HTTP_OK);
            }
        }
        return new JsonResponse(null,JsonResponse::HTTP_NOT_ACCEPTABLE);
    }

    public function registerUser(array $data): Response//todo : renvoyer aussi un token ?
    {

        if($this->validateKeys($data,self::REQUIRED_USER)){
            $email = $data["email"];
            $password = $data["password"];
            $passwordConfirm = $data["password_confirm"];
            $nom = $data["nom"];
            $prenom = $data["prenom"];
            if($password === $passwordConfirm){
                $user = new Utilisateur();
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $user,
                    $password
                );
                $user->setPassword($hashedPassword);

                $user->setEmail($email);
                $user->setNomUtilisateur($nom);
                $user->setPrenomUtilisateur($prenom);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return new JsonResponse(null,JsonResponse::HTTP_OK);
            }
        }
        return new JsonResponse(null,JsonResponse::HTTP_NOT_ACCEPTABLE);
    }

    private function validateKeys(array $data, array $keyArray)
    {
        return (count(array_intersect_key(array_flip($keyArray),$data)) == count($keyArray));
    }
}