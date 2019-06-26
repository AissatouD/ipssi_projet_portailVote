<?php
namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
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
        if ($newMeetingForm->isSubmitted() && $newMeetingForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newMeetingForm->getData());
            $em->flush();
            $isOk = true;
        }
        return $this->render(
            'meeting/add.html.twig',
            [
            'meetingForm' => $newMeetingForm->createView(),
            'isOk' => $isOk,
            ]
        );
    }
    /**
     * @Route(path="/edit/{id}")
     */
    public function edit(Request $request, Meeting $meeting): Response
    {
        $isOk = false;
        $newMeetingForm = $this->createForm(MeetingType::class, $meeting);
        $newMeetingForm->handleRequest($request);
        if ($newMeetingForm->isSubmitted() && $newMeetingForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $isOk = true;
        }
        return $this->render(
            'meeting/edit.html.twig',
            [
            'meetingForm' => $newMeetingForm->createView(),
            'isOk' => $isOk
            ]
        );
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
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Meeting::class);

        $meetings = $repository->findAll();

        return $this->render(
            'meeting/list.html.twig',
            [
                'meetings' => $repository->findAll(),
            ]
        );


        return $this->render('meeting/list.html.twig', [
            'meetings' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request)
    {
        /** @var MeetingRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Meeting::class);
        $keyword = $request->request->get('search');

        $result = $repo->getTitle($keyword);
dump($result);exit;
        return $this->render('meeting/search.html.twig', [
            'result' => $result]);

    }
}

