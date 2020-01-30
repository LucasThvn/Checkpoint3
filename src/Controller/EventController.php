<?php

namespace App\Controller;

use App\Repository\EventNameRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event")
     */
    public function index(EventRepository $eventRepository, EventNameRepository $eventNameRepository)
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
            'eventNames' => $eventNameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="eventName")
     * @param EventRepository $eventRepository
     * @param EventNameRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function eventByCategory(EventRepository $eventRepository, EventNameRepository $eventNameRepository, $id)
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findByEventName([$id]),
            'eventNames' => $eventNameRepository->findAll(),
        ]);
    }
}
