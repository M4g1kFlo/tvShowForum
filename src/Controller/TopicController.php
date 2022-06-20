<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TopicRepository;


class TopicController extends AbstractController
{
    #[Route('/', name: 'app_topic')]
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

    #[Route('/{slug}', name: 'topic_id')]
    public function topicView(TopicRepository $topicRepo,string $slug): Response{
        return $this->render('topic/topic.html.twig', [
            'topic' => $topicRepo->findOneBy(["slug"=>$slug]),
        ]);
    }
}
