<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function index()
    {
        return $this->render('user/userAccount.html.twig', [
            'controller_name' => 'UserAccountController',
        ]);
    }
}
