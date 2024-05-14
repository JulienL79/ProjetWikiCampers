<?php

namespace App\Controller;

use App\Repository\AvailabilityRepository;
use App\Form\RentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class RentController extends AbstractController
{
    #[Route('/rent', name: 'app_rent', methods: ['GET', 'POST'])]
    public function index(Request $request, AvailabilityRepository $availabilityRepository, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(RentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $formData = $form->getData();

            $maxPrice = $formData['maxPrice'];
            $searchStartDate = $formData['searchStartDate'];
            $searchEndDate = $formData['searchEndDate'];

            $result = $availabilityRepository->findVehicle($searchStartDate, $searchEndDate, $maxPrice);
            if (count($result) == 0) {
                $result = $availabilityRepository->findVehicleAdjust($searchStartDate, $searchEndDate, $maxPrice, 1);

                if (count($result) == 0) {
                    $this->addFlash(
                        'danger',
                        'Aucun véhicule disponible'
                    );
                } else {

                    $this->addFlash(
                        'warning',
                        'Voici les véhicules disponibles à +/- 1 jour'
                    );
                }
            } else {
                $this->addFlash(
                    'success',
                    'Voici les véhicules disponibles aux dates recherchées'
                );
            }

            // Utiliser le repository pour récupérer les véhicules disponibles
            $availableVehicles = $paginator->paginate(
                $result,
                $request->query->getInt('page', 1),
                10
            );

            // Retourner la réponse avec la vue et les données des véhicules disponibles
            return $this->render('pages/rent/result.html.twig', [
                'availableVehicles' => $availableVehicles,
                'period' => $searchStartDate->diff($searchEndDate)->d + 1
            ]);
        }

        return $this->render('pages/rent/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
