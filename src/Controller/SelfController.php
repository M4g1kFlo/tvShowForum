<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Trait\RoleTrait;
use App\Form\SelfType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;



#[Route('/self', name: 'self-')]
class SelfController extends AbstractController
{
    use RoleTrait;

    #[Route('/', name: 'info')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        $user = $this->getUser();
        $form = $this->createForm(SelfType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('self/index.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/close', name: 'close')]
    public function selfClose(EntityManagerInterface $entityManager): Response{
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        $user = $this->getUser();
        $user->setActivated(false);
        $entityManager->flush();

        return $this->redirectToRoute('self-info');
    }
}
