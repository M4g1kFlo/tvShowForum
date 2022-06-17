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
                12,
                0
            ),
        ]);
    }
}
