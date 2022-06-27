<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/category', name: 'category-')]
class CategoryController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'all')]
    public function index(CategoryRepository $catRepo): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $catRepo->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/add', name: 'add')]
    public function categoryAdd(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $category->setSlug($this->slugger->slug($category->getTitle()));

            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('category/add.html.twig', [
            'catForm' => $form->createView(),
        ]);
    }
    
    #[IsGranted('ROLE_ADMINISTRATOR')]
    #[Route('/edit/{slug}', name: 'edit')]
    public function categoryEdit(Category $category,EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $category->setSlug($this->slugger->slug($category->getTitle()));

            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('category/add.html.twig', [
            'catForm' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'id')]
    public function categoryView(Category $category): Response
    {
        return $this->render('category/category.html.twig', [
            'topics' => $category->getPosts(),
            'category' => $category,
        ]);
    }
}
