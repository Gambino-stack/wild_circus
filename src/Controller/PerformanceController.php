<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Performance;
use App\Form\CommentType;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerformanceController extends AbstractController
{
    /**
     * @Route ("/show/{id}", name="show", methods={"POST", "GET"})
     * @param Performance $performance
     * @param Request $request
     * @return Response
     */
    public function show(Performance $performance, Request $request): Response
    {
        if (!$performance) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setPerformance($performance);
            $comment->setAuthor($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a bien été ajouté 👌');
            return $this->redirectToRoute('home');
        }

        return $this->render("performances/show.html.twig", [
            'performance' => $performance,
            'form' => $form->createView()
            ]);
    }
}
