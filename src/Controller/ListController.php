<?php

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    // Cette méthode est mappée à la route "/list" et porte le nom "app_list".
    #[Route('/list', name: 'app_list')]
    public function index(RecordRepository $recordRepository): Response
    {
        // Récupère l'utilisateur actuellement connecté à partir du contexte de sécurité.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté ou n'est pas valide, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Récupère tous les enregistrements depuis la base de données via le RecordRepository.
        $records = $recordRepository->findAll();

        // Rend la vue associée à la liste des enregistrements, en passant la liste 'records' au template.
        return $this->render('list/index.html.twig', [
            // Passe les enregistrements récupérés au template Twig pour affichage.
            'records' => $records,
        ]);
    }
}
