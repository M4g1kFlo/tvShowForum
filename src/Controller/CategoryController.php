<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;

#[Route('/category', name: 'category-')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'all')]
    public function index(CategoryRepository $catRepo): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $catRepo->findAll(),
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
