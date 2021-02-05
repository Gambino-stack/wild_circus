<?php

namespace App\Controller;

use App\Repository\TarifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifsController extends AbstractController
{
    /**
     * @Route("/prices", name="prices")
     * @param TarifsRepository $tarifsRepository
     * @return Response
     */
    public function index(TarifsRepository $tarifsRepository): Response
    {
        return $this->render('tarifs/show.html.twig', [
            'prices' => $tarifsRepository->findAll(),
        ]);
    }
}
