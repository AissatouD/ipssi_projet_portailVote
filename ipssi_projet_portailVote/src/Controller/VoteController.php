<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/vote", name="vote")
*/
class VoteController extends AbstractController
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request): Response
    {
        $isOk = false;
        
        $newVoteForm = $this->createForm(VoteType::class);
        $newVoteForm->handleRequest($request);
        if ($newVoteForm->isSubmitted() && $newVoteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newvote = new Vote();
            $id = $request->get("id");
            $vote = $request->request->get("vote");
            $note = $vote["note"];
            // $this->denyAccessUnlessGranted('ROLE_USER');
            // $user = $this->getUser();
            // var_dump($user);
            // exit;
    
            $newvote->setIdMeeting($id);
            $newvote->setNote($note);
            $em->persist($newvote);
            $em->flush();
            $isOk = true;
            return $this->redirectToRoute('meetingapp_meeting_list');
        }
        return $this->render(
            'vote/add.html.twig',
            [
            'voteForm' => $newVoteForm->createView(),
            'isOk' => $isOk,
            ]
        );
    }
    // public function index()
    // {
    //     return $this->render('vote/index.html.twig', [
    //         'controller_name' => 'VoteController',
    //     ]);
    // }
}
