<?php
declare(strict_types = 1);

namespace App\Controller;



use App\Entity\User;
use App\Form\UserInscriptionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Route("user/inscription", name="user_inscription")
     */

    public function inscription( Request $request, ObjectManager $manager,  UserPasswordEncoderInterface $encoder ) : Response{



        $user= new User();
        $newUserForm = $this->createForm(UserInscriptionType::class, $user); // on relie les champs de l'utilisateur aux champs du formulaire

        $newUserForm->handleRequest($request);
        if($newUserForm->isSubmitted() && $newUserForm->isValid()) {

            //$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            //$user->setPassword($password);

            $manager->persist($user);

            $hash= $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->flush();


            return $this->redirectToRoute('app_login'); // pour la redirection mettre le nom de la route
        }


        return $this->render('user/userInscription.html.twig', [
            'newUserForm' => $newUserForm->createView(),

        ]);
    }
    /**
     * @Route("/update/{id}")
     *
     */

    public function update(Request $request,User $user): Response
    {
        $isOk = false;
        $newUserForm = $this->createForm(UserType::class, $user);
        $newUserForm->handleRequest($request);
        if($newUserForm->isSubmitted() && $newUserForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $isOk = true;
        }
        return $this->redirectToRoute("app_user_update");
        return $this->render('user/update.html.twig', [
            'userForm' => $newUserForm->createView(),
            'isOk' => $isOk
        ]);
    }


}
