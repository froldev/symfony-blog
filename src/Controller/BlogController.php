<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', []);
    }

    #[Route('/blog/new', name: 'blog_create')]
    #[Route('/blog/{id}/edit', name: 'blog_edit')]
    public function form(Article $article = null, Request $request, ObjectManager $objectManager) {

        if (!$article) {
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $objectManager->persist($article);
            $objectManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);

        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
