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
     * @Route("/login", name="login")
     */
    public function userLogin(){


        /*
        // Pour gérer les erreur de connexion
        $error = $authUtils->getLastAuthenticationError();

        // le dernier username entrée par le user
        $lastUsername = $authUtils->getLastUsername();

        if ($error){
            $this->addFlash('login', 'Erreur d\'authenfication, veuillez vérifier vos accès et réessayer');
        }

        // connexion en tant qu'admin
        if (TRUE=== $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('user_admin');
        }

        // connexion en tant qu'utilisateur membre
        if (TRUE=== $this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('user_account');
        }

*/
        return $this->render('security/login.html.twig');

    }

    /**
     * @return mixed
     * @Route("/logout", name="logout")
     */

    public function userLogout(){

        // déconnexion
        if($this->get('security.token_storage')->getToken()->getUser()){
            $this->get('security.token_storage')->setToken(null);
            $this->addFlash('logout', 'Logout');
            return $this->redirectionToRoute('home');
        }
    }


}
