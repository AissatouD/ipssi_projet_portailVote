<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserAdminController extends AbstractController
{
    /**
     * @Route("/user/admin", name="user_admin")
     */
    public function index()
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('user/userAdmin.html.twig', [
            'controller_name' => 'UserAdminController',
        ]);
    }

}
