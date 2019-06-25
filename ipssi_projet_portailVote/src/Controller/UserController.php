<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/login.html.twig', [
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
    /**
     * @Route("/update/{id}")
     */

    public function update(Request $request,User $user): Response
    {
        $isOk = false;
        $newUserForm = $this->createForm(UserType::class, $user);
        $newUserForm->handleRequest($request);
        if($newUserForm->isSubmitted() && $newUserForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $isOk = true;
        }
        return $this->redirectToRoute("app_user_update");
        return $this->render('user/update.html.twig', [
            'userForm' => $newUserForm->createView(),
            'isOk' => $isOk
        ]);
    }


}
