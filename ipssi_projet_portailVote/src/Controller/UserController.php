<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("admin/user/list", name="admin_user_list", methods={"POST","GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listUser(UserRepository $userRepository): Response
    {
        return $this->render('admin/listUser.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/new/user", name="admin_user_new", methods={"POST","GET"})
     * @param Request $request
     * @return Response
     */
    public function newUser(Request $request): Response
    {
        $user = new User();
        $roles = $user->getRoles();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_admin');
        }

        return $this->render('admin/newUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin_user_detail", methods={"POST","GET"})
     * @param User $user
     * @return Response
     */
    public function showUser(User $user): Response
    {
        return $this->render('admin/showUser.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("admin/user/edit/{id}", name="admin_user_edit", methods={"POST","GET"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_list', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('admin/editUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /*

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *@Route("admin/user/delete/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    /*
    public function deleteUser(Request $request, User $user): Response
    {
        $user = new User;
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->render('admin/userDelete.html.twig',
            ['user'=> $user]);


    }*/
    /**
     * @param User $user
     * @return Response
     * @Route("admin/user/delete/{id}", name="admin_user_delete", methods={"GET"})
     */

    public function delete(User $user, String $successMessage): Response
    {
        $successMessage ->addFlash("success", "This is a success message");
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_user_list');
    }

}
