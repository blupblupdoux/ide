<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/patient", name="api_patient")
 */
class PatientController extends AbstractController
{
    /**
     * @Route("/", name="browse")
     */
    public function browse(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PatientController.php',
        ]);
    }
}
