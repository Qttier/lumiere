<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /**
     * Cette route est mappée à "/register" pour afficher et traiter le formulaire d'inscription.
     * Le nom de la route est "app_register".
     */
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Crée une nouvelle entité User qui sera utilisée pour le formulaire.
        $user = new User();
        
        // Crée un formulaire basé sur la classe RegisterType et lie-le à l'entité User.
        $form = $this->createForm(RegisterType::class, $user);
        
        // Traite la requête HTTP pour remplir le formulaire avec les données envoyées.
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Hache le mot de passe de l'utilisateur avant de l'enregistrer dans la base de données.
            $hashedPassword = $passwordHasher->hashPassword(
                $user, 
                $form->get('plainPassword')->getData() // Récupère le mot de passe en clair du formulaire.
            );
            
            // Définit le mot de passe haché sur l'entité User.
            $user->setPassword($hashedPassword);

            // Définit les rôles de l'utilisateur, ici un rôle par défaut 'ROLE_USER'.
            $user->setRoles(['ROLE_USER']);

            // Persiste l'entité User dans la base de données.
            $entityManager->persist($user);
            $entityManager->flush();

            // Ajoute un message pour informer l'utilisateur que l'entité a été modifié
            $this->addFlash('success', 'Succesfully registred');

            // Redirige vers la page de connexion après une inscription réussie.
            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire n'est pas soumis ou valide, rend la vue pour afficher le formulaire d'inscription.
        return $this->render('register/index.html.twig', [
            'form' => $form, // Passe le formulaire au template pour l'affichage.
            'user' => $user, // Passe l'entité User pour préremplir le formulaire si nécessaire.
        ]);
    }
}
