<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Make;
use App\Repository\Exception\RowNotFoundException;
use App\Entity\VehicleType;
use App\Repository\VehicleTypeRepository;
use App\Service\SearchServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @return Response
     */
    public function main(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        $vehicleTypes = $vehicleTypeRepository->fetchAllByAlphabet();

        return $this->render('main.html.twig', ['vehicleTypes' => $vehicleTypes]);
    }

    /**
     * @Route("/makes/{code}", name="makes")
     * @param Request $request
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @return Response
     * @throws Exception
     */
    public function makes(Request $request, VehicleTypeRepository $vehicleTypeRepository): Response
    {
        $code = (string)$request->get('code');
        $vehicleType = $vehicleTypeRepository->findByCode($code);
        $makes = $vehicleType->getMakes();
        return $this->render('makes.html.twig', ['makes' => $makes, 'vehicleTypeId' => $vehicleType->getId()]);
    }

    /**
     * @Route("/models/{type}/{make}", name="models")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SearchServiceInterface $searchService
     * @return Response
     */
    public function model(Request $request, EntityManagerInterface $entityManager, SearchServiceInterface $searchService): Response
    {
        $type = (int)$request->get('type');
        $make = (int)$request->get('make');

        try {
            $typeObject = $entityManager->getRepository(VehicleType::class)->findById($type);
            $makeObject = $entityManager->getRepository(Make::class)->findById($make);
        } catch (RowNotFoundException $e) {
            return new Response('', 404);
        }

        $results = $searchService->search($makeObject, $typeObject);

        if (count($results) === 0) {
            return new Response('', 404);
        }

        return $this->json($results);
    }
}
