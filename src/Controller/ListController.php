<?php

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function index(RecordRepository $recordRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            return $this->redirectToRoute('app_login');
        }
        $records = $recordRepository->findAll();
        return $this->render('list/index.html.twig', [
            'records' => $records,
        ]);
    }
}
