<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Service\weatherService;
use DateTime;
use DateTimeInterface;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="app_home")
     */
    public function index(weatherService $weatherservice, ManagerRegistry $doctrine): Response
    {

        $data = $weatherservice->getWeather();
        $historic = new Historique();
        $historicRepository = new HistoriqueRepository($doctrine);
        $historic->setTemperature($data['main']['temp']);
        $date = new DateTime();
        $historic->setDate($date->setTimestamp($data['dt']));

        $historicRepository->add($historic);
        $dataHistoric = $historicRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'data' => $data,
            'historiques' =>$dataHistoric,
        ]);
    }
}
