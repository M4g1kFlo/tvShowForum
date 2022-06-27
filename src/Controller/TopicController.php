<?php

namespace App\Controller;

use App\Controller\Trait\RoleTrait;
use App\Entity\Comment;
use App\Entity\Topic;
use App\Form\CommentType;
use App\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TopicRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/topic', name: 'topic-')]
class TopicController extends AbstractController
{

    Use RoleTrait;

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'all')]
    public function index(TopicRepository $topicRepo): Response
    {
        return $this->render('topic/index.html.twig', [
            'topics' => $topicRepo->findBy(
                [],
                ['pubished_date' => 'desc'],
                120,
                0
            ),
        ]);
    }

    #[Route('/new', name: 'create')]
    public function createTopic(UserInterface $user,Request $request, EntityManagerInterface $entityManager): Response{

        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $topic->setPubished_Date(new DateTimeImmutable());
            $topic->setAuthor($user);
            $topic->setClosed(false);
            $topic->setSlug($this->slugger->slug($topic->getTitle())->lower());

            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic-all');
        }

        return $this->render('topic/create.html.twig', [
            'topicForm' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'id')]
    public function topicView(EntityManagerInterface $entityManager,Topic $topic,TopicRepository $topicRepo,string $slug,Request $request): Response{

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $comment->setAuthor($this->getUser());
            $comment->setDate(new DateTimeImmutable());
            $comment->setTopic($topic);
            $comment->setHidden(false);

            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render('topic/topic.html.twig', [
            'topic' => $topicRepo->findOneBy(["slug"=>$slug]),
            'commentForm' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/{slug}/close', name: 'close')]
    public function topicClose(EntityManagerInterface $entityManager,Topic $topic): Response{
        $topic->setClosed(true);
        $entityManager->flush();

        return $this->redirectToRoute('topic-id',['slug'=>$topic->getSlug()]);
    }

    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/{id}/hide', name: 'comment-close')]
    public function commentHide(EntityManagerInterface $entityManager,Comment $comment,TopicRepository $topicRepo): Response{
        $comment->setHidden(true);
        $entityManager->flush();

        return $this->redirectToRoute('topic-id',['slug'=>$comment->getTopic()->getSlug()]);
    }
}
