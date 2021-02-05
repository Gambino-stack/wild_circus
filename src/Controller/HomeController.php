<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param PerformanceRepository $performanceRepository
     * @param Request $request
     * @return Response
     */
    public function index(PerformanceRepository $performanceRepository, Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Votre message a bien été envoyé.');
            $this->redirectToRoute('home');

        }
        return $this->render('home/index.html.twig', [
            'performances' => $performanceRepository->findAll(),
            'form' => $form->createView()
        ]);
    }
}
