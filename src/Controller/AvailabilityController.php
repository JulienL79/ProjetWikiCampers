<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Repository\AvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AvailabilityType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(AvailabilityRepository $repositoryA, PaginatorInterface $paginator, Request $request): Response
    {
        $availabilities = $paginator->paginate(
            $repositoryA->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/availability/index.html.twig', [
            'availabilities' => $availabilities
        ]);
    }

    /**
     * This controller allow us to edit an availability
     *
     * @param Availability $availability
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/availability/edit/{id}', name: 'app_availability.edit', methods: ['GET', 'POST'])]
    public function edit(Availability $availability, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $availability = $form->getData();

            $manager->persist($availability);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre disponibilité a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_availability');
        }

        return $this->render('pages/availability/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete an availability
     *
     * @param EntityManagerInterface $manager
     * @param Availability $availability
     * @return Response
     */

    #[Route('/availability/delete/{id}', 'app_availability.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Availability $availability): Response
    {
        $manager->remove($availability);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre disponibilité a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_availability');
    }
}
