<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin', name: 'admin-')]
class AdminController extends AbstractController
{
    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/', name: 'users')]
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepo->findAll(),
        ]);
    }
    
    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/{id}', name: 'user')]
    public function changeStatus(EntityManagerInterface $entityManager,User $user): Response
    {
        $user->setActivated(!$user->isActivated());
        $entityManager->flush();
        return $this->redirectToRoute('admin-users');
    }
}
