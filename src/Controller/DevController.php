<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dev', name:"app_dev")]
class DevController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): Response
    {
        // ... e.g. get the user data from a registration form
        $user = new Utilisateur();
        $plaintextPassword = "singe";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $user->setEmail("virgile.louis.mathieu@gmail.com");
        $user->setNomUtilisateur("MATHIEU");
        $user->setPrenomUtilisateur("Virgile");

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('dev/index.html.twig', [
            'controller_name' => 'DevController',
        ]);
    }
}
