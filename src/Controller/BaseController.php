<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BaseController extends AbstractController
{
    // Cette méthode est mappée à la route racine ("/") et porte le nom "app_base".
    #[Route('/', name: 'app_base')]
    public function index(): Response
    {
        // Récupère l'utilisateur actuellement connecté à partir du contexte de sécurité.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté ou n'est pas valide, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Si l'utilisateur est authentifié, redirige vers la route "app_home".
        return $this->redirectToRoute('app_home');
    }
}
