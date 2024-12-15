<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Route pour la page de connexion.
     * Cette méthode gère l'affichage du formulaire de connexion et les erreurs liées à l'authentification.
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupère l'erreur d'authentification si une erreur a eu lieu (ex: mauvais mot de passe).
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier nom d'utilisateur saisi par l'utilisateur, si disponible.
        $lastUsername = $authenticationUtils->getLastUsername();

        // Rend la vue 'login.html.twig' et passe les données nécessaires au template.
        // Ces données comprennent :
        // - 'last_username' : le dernier nom d'utilisateur utilisé,
        // - 'error' : l'erreur d'authentification, s'il y en a une.
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Route pour la déconnexion.
     * La méthode 'logout' est interceptée par Symfony et n'a pas besoin de logique spécifique dans le contrôleur.
     * Le système de sécurité se charge de la déconnexion automatiquement.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide car Symfony gère la déconnexion automatiquement via la configuration du firewall.
        // L'exception levée est simplement un placeholder pour indiquer que ce contrôleur est intercepté par Symfony.
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
