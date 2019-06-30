<?php
namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Swift_Mailer;
use App\Entity\User;
use App\Repository\UserRepository;
/**
     * @Route("/meeting", name="meeting")
     */
class MeetingController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/add", name="_add")
     */
    public function add(Request $request, Swift_Mailer $mailer): Response
    {
        $isOk = false;
        $newMeetingForm = $this->createForm(MeetingType::class);
        $newMeetingForm->handleRequest($request);
        if ($newMeetingForm->isSubmitted() && $newMeetingForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var UserRepository $repo */
            $repo = $em->getRepository(User::class);
            foreach ($repo->findAll() as $user) {
        
        $message = (new \Swift_Message('Hello Email'))
                ->setFrom('super_dev@example.com')
                ->setTo($user->getMail())
                ->setBody(
                    "Mail bien envoyé",
                    'text/html'
                );

                $mailer->send($message);
                }

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
     * @param Request $request
     * @param Meeting $meeting
     * @return Response
     * @Route(path="/edit/{id}", name="_edit")
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
     * @param Meeting $meeting
     * @return Response
     * @Route(path="/delete/{id}", name="_delete")
     */
    public function delete(Meeting $meeting): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('meeting_list');
    }

    /**
     * @Route(path="/list" ,name="_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function list(PaginatorInterface $paginator, Request $request): Response
    {

        $repository = $this->getDoctrine()->getRepository(Meeting::class);
        $pagination = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 );/*limit per page*/

        $repository = $this->getDoctrine()->getRepository(Meeting::class);
        $meetings = $repository->findAll();
        return $this->render(
            'meeting/list.html.twig',
            [
                'pagination'=>$pagination,
                'meetings' => $meetings,
            ]
        );
    }

    /**
     * @Route(path="/view/{id}", name="_view")
     */
    public function view(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Meeting::class);
        $meeting = $repository->find($id);
        if ($meeting === null) {
            throw $this->createNotFoundException();
        }
        return $this->render('meeting/view.html.twig', [
            'meeting' => $meeting
        ]);
    }
        
    /**
    * @Route(path="/top", name="_top")
    */
    public function top10(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Meeting::class);
        $topMeeting = $repository->findBy([], ['note' => 'DESC'], 10);

        return $this->render(
            'meeting/top10.html.twig',
            [
                'topMeeting' => $topMeeting,
            ]
        );

    }



        /*return $this->render('meeting/list.html.twig', [
            'meetings' => $pagination
        ]);
    }*/

    /**
     * @param Request $request
     * @return Response
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        /** @var MeetingRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Meeting::class);
        
        $keyword = $request->request->get('search');
        
        $result = $repo->getTitle($keyword);
        
        return $this->render('meeting/search.html.twig', [
            'result' => $result]);
    }
}
