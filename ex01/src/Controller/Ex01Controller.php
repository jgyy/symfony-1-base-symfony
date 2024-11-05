<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/e01')]
class Ex01Controller extends AbstractController
{
    private array $articles = [
        'cats' => [
            'title' => 'All About Cats',
            'content' => 'Cats are fascinating creatures that have been domesticated for thousands of years. They are known for their independence, agility, and affectionate nature.'
        ],
        'dogs' => [
            'title' => 'Understanding Dogs',
            'content' => 'Dogs are loyal companions that have evolved alongside humans for millennia. They are known for their devotion, intelligence, and social nature.'
        ],
        'birds' => [
            'title' => 'World of Birds',
            'content' => 'Birds are remarkable creatures that have conquered the skies. With their ability to fly and diverse species, they play crucial roles in ecosystems worldwide.'
        ]
    ];

    #[Route('', name: 'app_e01_index')]
    public function index(): Response
    {
        return $this->render('ex01/index.html.twig', [
            'articles' => $this->articles
        ]);
    }

    #[Route('/{category}', name: 'app_e01_article')]
    public function article(string $category): Response
    {
        if (!isset($this->articles[$category])) {
            return $this->redirectToRoute('app_e01_index');
        }

        return $this->render('ex01/article.html.twig', [
            'article' => $this->articles[$category],
            'category' => $category
        ]);
    }
}
