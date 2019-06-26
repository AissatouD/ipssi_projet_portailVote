<?php
declare(strict_types = 1);

namespace App\Controller;



use App\Form\UserType;
use App\Entity\User;
use App\Form\UserInscriptionType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;




class UserInscriptionController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserInscriptionController',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("user/inscription", name="user_inscription")
     */

    public function inscription( Request $request) : Response{



        $newUserForm = $this->createForm(UserInscriptionType::class);
        $newUserForm->handleRequest($request);
        if($newUserForm->isSubmitted() && $newUserForm->isValid()) {

            //$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            //$user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUserForm->getData());
            $em->flush();
            //$isOk = true;

            return $this->redirectToRoute('login'); // pour la redirection mettre le nom de la route
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
