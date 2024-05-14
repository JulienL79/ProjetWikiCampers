<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\Availability;
use App\Form\VehicleType;
use App\Form\AvailabilityType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) // Injectez l'EntityManager dans le constructeur
    {
        
    }

    #[Route('/vehicle', name: 'app_vehicle')]
    public function index(VehicleRepository $repositoryV, PaginatorInterface $paginator, Request $request): Response
    {
        $vehicles = $paginator->paginate(
            $repositoryV->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/vehicle/index.html.twig', [
            'vehicles' => $vehicles
        ]);
    }

    /**
     * This controller show a form which create an vehicle
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/vehicle/new', name: 'app_vehicle.new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle = $form->getData();

            $this->entityManager->persist($vehicle);
            $this->entityManager->flush();


            $this->addFlash(
                'success',
                'Votre véhicule a été créé avec succès !'
            );

            // Redirigez vers une autre page ou effectuez une autre action
            return $this->redirectToRoute('app_vehicle');
        }

        return $this->render(
            'pages/vehicle/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * This controller allow us to edit an vehicle
     *
     * @param Vehicle $vehicle
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/vehicle/edit/{id}', name: 'app_vehicle.edit', methods: ['GET', 'POST'])]
    public function edit(Vehicle $vehicle, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();

            $manager->persist($vehicle);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre véhicule a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_vehicle');
        }

        return $this->render('pages/vehicle/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete an vehicle
     *
     * @param EntityManagerInterface $manager
     * @param Vehicle $vehicle
     * @return Response
     */

    #[Route('/vehicle/delete/{id}', 'app_vehicle.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Vehicle $vehicle): Response
    {
        $manager->remove($vehicle);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre vehicule a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_vehicle');
    }

    #[Route('/vehicle/{id}/add-availability', name: 'app_vehicle_add_availability', methods: ['GET', 'POST'])]
    public function addAvailability(Request $request, Vehicle $vehicle): Response
    {
        // Créer un nouveau formulaire pour ajouter une disponibilité
        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $availability = $form->getData();

            // Associer la disponibilité au véhicule
            $availability->setIdVehicle($vehicle);
            $availability->setStatusA(true);

            // Enregistrer la disponibilité dans la base de données
            $this->entityManager->persist($availability);
            $this->entityManager->flush();

            // Ajouter un message flash
            $this->addFlash(
                'success',
                'La disponibilité a été ajoutée avec succès.'
            );

            // Rediriger vers la page du véhicule ou une autre page
            return $this->redirectToRoute('app_vehicle');
        }

        // Afficher le formulaire d'ajout de disponibilité
        return $this->render('pages/vehicle/add_availability.html.twig', [
            'form' => $form->createView(),
            'vehicle' => $vehicle,
            'availability' => $availability
        ]);
    }
}
