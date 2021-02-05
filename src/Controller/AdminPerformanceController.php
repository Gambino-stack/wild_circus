<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\PerformanceType;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/performance")
 */
class AdminPerformanceController extends AbstractController
{
    /**
     * @Route("/", name="performance_index", methods={"GET"})
     */
    public function index(PerformanceRepository $performanceRepository): Response
    {
        return $this->render('adminPerformance/index.html.twig', [
            'performances' => $performanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="performance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $performance = new Performance();
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($performance);
            $entityManager->flush();

            $this->addFlash('success', 'La performance a bien été ajoutée ✅');


            return $this->redirectToRoute('performance_index');
        }

        return $this->render('adminPerformance/new.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="performance_show", methods={"GET"})
     */
    public function show(Performance $performance): Response
    {
        return $this->render('adminPerformance/show.html.twig', [
            'performance' => $performance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="performance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Performance $performance): Response
    {
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La performance a bien été modifiée ✅');

            return $this->redirectToRoute('performance_index');
        }

        return $this->render('adminPerformance/edit.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="performance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Performance $performance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$performance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($performance);
            $entityManager->flush();
            $this->addFlash('danger', '🚨 La performance a bien été supprimée');

        }

        return $this->redirectToRoute('performance_index');
    }
}
