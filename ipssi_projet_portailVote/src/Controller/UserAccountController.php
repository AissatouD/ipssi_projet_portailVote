<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
