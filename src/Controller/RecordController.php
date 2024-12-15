<?php

namespace App\Controller;

use App\Entity\Record;
use App\Form\RecordType;
use App\Repository\RecordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/record')]
final class RecordController extends AbstractController
{
    // Cette méthode est mappée à la route "/record" pour afficher tous les enregistrements d'un utilisateur.
    #[Route(name: 'app_record_index', methods: ['GET'])]
    public function index(RecordRepository $recordRepository): Response
    {
        // Récupère l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Récupère les enregistrements appartenant à l'utilisateur connecté via le RecordRepository.
        return $this->render('record/index.html.twig', [
            // Passe les enregistrements filtrés par l'ID de l'utilisateur au template Twig.
            'records' => $recordRepository->findBy(['owner' => $this->getUser()->getId()]),
        ]);
    }

    // Cette méthode est mappée à la route "/record/new" pour créer un nouvel enregistrement.
    #[Route('/new', name: 'app_record_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Crée un nouvel objet Record pour le formulaire.
        $record = new Record();
        // Crée le formulaire à partir de la classe RecordType.
        $form = $this->createForm(RecordType::class, $record);
        // Traite la requête HTTP pour remplir le formulaire avec les données envoyées.
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Associe l'enregistrement à l'utilisateur actuellement connecté.
            $record->setOwner($this->getUser());
            // Persiste l'objet Record dans la base de données.
            $entityManager->persist($record);
            // Effectue les modifications dans la base de données.
            $entityManager->flush();

            // Redirige vers la page des enregistrements une fois l'enregistrement effectué.
            return $this->redirectToRoute('app_record_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue du formulaire de création d'enregistrement.
        return $this->render('record/new.html.twig', [
            'record' => $record,
            'form' => $form,
        ]);
    }

    // Cette méthode est mappée à la route "/record/{id}" pour afficher un enregistrement spécifique.
    #[Route('/{id}', name: 'app_record_show', methods: ['GET'])]
    public function show(Record $record): Response
    {
        // Récupère l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Rend la vue pour afficher un enregistrement spécifique.
        return $this->render('record/show.html.twig', [
            'record' => $record,
        ]);
    }

    // Cette méthode est mappée à la route "/record/{id}/edit" pour modifier un enregistrement existant.
    #[Route('/{id}/edit', name: 'app_record_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Record $record, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Crée et traite le formulaire de modification à partir de l'entité Record existante.
        $form = $this->createForm(RecordType::class, $record);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistre les modifications dans la base de données.
            $entityManager->flush();

            // Redirige vers la page des enregistrements après modification.
            return $this->redirectToRoute('app_record_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue pour afficher le formulaire de modification.
        return $this->render('record/edit.html.twig', [
            'record' => $record,
            'form' => $form,
        ]);
    }

    // Cette méthode est mappée à la route "/record/{id}" pour supprimer un enregistrement.
    #[Route('/{id}', name: 'app_record_delete', methods: ['POST'])]
    public function delete(Request $request, Record $record, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérifie si l'utilisateur est authentifié et s'il est une instance de la classe User.
        if (!$user instanceof \App\Entity\User) {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion.
            return $this->redirectToRoute('app_login');
        }

        // Vérifie que le token CSRF de suppression est valide.
        if ($this->isCsrfTokenValid('delete'.$record->getId(), $request->getPayload()->getString('_token'))) {
            // Supprime l'enregistrement de la base de données.
            $entityManager->remove($record);
            // Applique les changements à la base de données.
            $entityManager->flush();
        }

        // Redirige vers la page des enregistrements après suppression.
        return $this->redirectToRoute('app_record_index', [], Response::HTTP_SEE_OTHER);
    }
}
