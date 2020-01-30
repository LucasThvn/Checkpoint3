<?php

namespace App\Controller;

use App\Entity\EventName;
use App\Form\EventNameType;
use App\Repository\EventNameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/eventName")
 */
class AdminEventNameController extends AbstractController
{
    /**
     * @Route("/", name="eventName_index", methods={"GET"})
     */
    public function index(EventNameRepository $eventNameRepository): Response
    {
        return $this->render('admin_eventName/index.html.twig', [
            'categories' => $eventNameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="eventName_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventName = new EventName();
        $form = $this->createForm(EventNameType::class, $eventName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventName);
            $entityManager->flush();

            return $this->redirectToRoute('eventName_index');
        }

        return $this->render('admin_eventName/new.html.twig', [
            'eventName' => $eventName,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eventName_show", methods={"GET"})
     */
    public function show(EventName $eventName): Response
    {
        return $this->render('admin_eventName/show.html.twig', [
            'eventName' => $eventName,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eventName_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventName $eventName): Response
    {
        $form = $this->createForm(EventNameType::class, $eventName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eventName_index');
        }

        return $this->render('admin_eventName/edit.html.twig', [
            'eventName' => $eventName,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eventName_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EventName $eventName): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventName->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventName);
            $entityManager->flush();
        }

        return $this->redirectToRoute('eventName_index');
    }
}
