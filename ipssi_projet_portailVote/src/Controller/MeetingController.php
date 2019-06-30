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
    * @Route(path="/list" ,name="_list")
    */
    public function list(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Meeting::class);
        $pagination = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3
        );/*limit per page*/
        $meetings = $repository->findAll();
        return $this->render(
            'meeting/list.html.twig',
            [
                'pagination'=>$pagination,
                'meetings' => $repository->findAll(),
            ]
        );
    }


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
                $message = (new Swift_Message('Hello yooyo'))
                        ->setFrom('dev-web@example.com')
                        ->setTo($user->getMail())
                        ->setBody(
                            " une nouvelle conférence wow!!  ",
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
