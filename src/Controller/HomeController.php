<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Cette méthode est mappée à la route "/home" et porte le nom "app_home".
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // Récupère l'utilisateur actuellement connecté à partir du contexte de sécurité.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté ou n'est pas valide, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Rend la vue associée à la page d'accueil, en passant des variables au template.
        return $this->render('home/index.html.twig', [
            // Passe le nom du contrôleur en tant que variable au template Twig.
            'controller_name' => 'HomeController',
        ]);
    }
}
