<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="login")
     */
    public function userLogin(Request $request, AuthenticationUtils $authUtils)
    {
        // Pour gérer les erreur de connexion
        $error = $authUtils->getLastAuthenticationError();

        // le dernier username entré par le user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

  /*  public function  connectionForm(){

        // on créé un nouvel objet user
        $connectionForm = new User();

        //on créé le queryBuilder grace a 'form.factory'
        $formBuilder = $this->createFormBuilder( $connectionForm);

        // on ajoute les champs du formulaire
        $formBuilder
            ->add('mail', EmailType::class)
            ->add('firstname',TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();
        //$formBuilder->handleRequest();

        //on retourne la vue
        return $this->render('security/login.html.twig', array(
            'form' => $formBuilder->createView(),

            ));
    }*/
}
