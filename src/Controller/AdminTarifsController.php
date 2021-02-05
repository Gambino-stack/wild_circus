<?php

namespace App\Controller;

use App\Entity\Tarifs;
use App\Form\TarifsType;
use App\Repository\TarifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tarifs")
 */
class AdminTarifsController extends AbstractController
{
    /**
     * @Route("/", name="tarifs_index", methods={"GET"})
     */
    public function index(TarifsRepository $tarifsRepository): Response
    {
        return $this->render('adminTarifs/index.html.twig', [
            'tarifs' => $tarifsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tarifs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tarif = new Tarifs();
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tarif);
            $entityManager->flush();
            $this->addFlash('success', 'Le tarif a bien été ajoutée ✅');

            return $this->redirectToRoute('tarifs_index');
        }

        return $this->render('adminTarifs/new.html.twig', [
            'tarif' => $tarif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarifs_show", methods={"GET"})
     */
    public function show(Tarifs $tarif): Response
    {
        return $this->render('adminTarifs/show.html.twig', [
            'tarif' => $tarif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tarifs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tarifs $tarif): Response
    {
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le tarif a bien été modifié ✅');

            return $this->redirectToRoute('tarifs_index');
        }

        return $this->render('adminTarifs/edit.html.twig', [
            'tarif' => $tarif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarifs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tarifs $tarif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tarif);
            $entityManager->flush();
            $this->addFlash('danger', '🚨 Le tarif a bien été supprimée');

        }

        return $this->redirectToRoute('tarifs_index');
    }
}
