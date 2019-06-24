<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{
    /**
     * @Route("/meeting", name="meeting")
     */
    public function index()
    {
        return $this->render('meeting/index.html.twig', [
            'controller_name' => 'MeetingController',
        ]);
    }
}
