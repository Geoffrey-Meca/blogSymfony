<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('articles/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/posts/{id}', name: 'show_post')]
    public function show(Post $post, Request $request, EntityManagerInterface $em)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);

        $comment->setCreatedAt(new \DateTime());
        $comment->setPost($post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('articles/post.html.twig', [
            'post' => $post,
            "form" => $form->createView()
        ]);
    }

    #[route('/addArticle', name: 'add_article')]
    public function addArticle(Request $request, EntityManagerInterface $em)
    {
        $article = new Post;
        $form = $this->createForm(PostType::class, $article);
        $article->setCreatedAt(new \DateTime());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('show_post', ['id' => $article->getId()]);
        }

        return $this->render('articles/addArticle.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
