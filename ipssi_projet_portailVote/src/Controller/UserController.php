<?php

namespace App\Controller;

use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function inscription( Request $request) : Response{

        $newUserForm = $this->createForm(UserType::class);
        $newUserForm->handleRequest($request);
        if($newUserForm->isSubmitted() && $newUserForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUserForm->getData());
            $em->flush();
            //$isOk = true;
        }
        return $this->render('user/userInscription.html.twig', [
            'newUserForm' => $newUserForm->createView(),
            //'isOk' => $isOk,
        ]);
    }



}
