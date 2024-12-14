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
        $records = $recordRepository->findAll();
        return $this->render('list/index.html.twig', [
            'records' => $records,
        ]);
    }
}