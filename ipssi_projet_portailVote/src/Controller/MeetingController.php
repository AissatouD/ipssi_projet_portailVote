<?php
declare(strict_types = 1);
namespace App\Controller;
use App\Entity\Meeting;
use App\Form\MeetingType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
     * @Route("/meeting", name="meeting")
     */
class MeetingController extends AbstractController
{
    /**
     * @Route("/add")
     */
    public function add(Request $request): Response 
    {
        $isOk = false;
        
        $newMeetingForm = $this->createForm(MeetingType::class);
        $newMeetingForm->handleRequest($request);
        if($newMeetingForm->isSubmitted() && $newMeetingForm->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($newMeetingForm->getData());
        $em->flush();
        $isOk = true;
        }
        return $this->render('meeting/add.html.twig', [
            'meetingForm' => $newMeetingForm->createView(),
            'isOk' => $isOk,
        ]);
    }
    /**
     * @Route(path="/edit/{id}")
     */
    public function edit(Request $request, Meeting $meeting): Response
    {
        $isOk = false;
        $newMeetingForm = $this->createForm(MeetingType::class, $meeting);
        $newMeetingForm->handleRequest($request);
        if($newMeetingForm->isSubmitted() && $newMeetingForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $isOk = true;
        }
        return $this->render('meeting/edit.html.twig', [
            'meetingForm' => $newMeetingForm->createView(),
            'isOk' => $isOk
        ]);
    }
    
    /**
     * @Route(path="/delete/{id}")
     */
    public function delete(Meeting $meeting): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('meetingapp_meeting_list');
    }
     /**
     * @Route(path="/list")
     */
    public function list(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Meeting::class);

        $pagination = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('meeting/list.html.twig', [
            'meetings' => $pagination
        ]);
    }
        
}