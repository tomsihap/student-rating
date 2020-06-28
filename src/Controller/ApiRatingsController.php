<?php


namespace App\Controller;


use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiRatingsController extends AbstractController
{
    /**
     * @param RatingRepository $ratingRepository
     * @return Response
     * @Route("/api/ratings/average")
     */
    public function getAllStudentsAverage(RatingRepository $ratingRepository) : Response {

        $average = $ratingRepository->findAverage()['average'];

        return new JsonResponse(['average' => $average], 200);
    }

}