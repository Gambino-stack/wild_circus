<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Show;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($reservation->getRepresentation()->getStock() > 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $reservation->setAuthor($this->getUser());
                $reservation->getRepresentation()->setStock($reservation->getRepresentation()->getStock() - 1);
                $entityManager->persist($reservation);
                $entityManager->flush();
                $this->addFlash('success', 'Votre réservation a bien été effectuée');
                return $this->redirectToRoute('reservation');
            } else {
                $this->addFlash('danger', 'La représentation séléctionnée est dejà complete');
            }
        }

        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
