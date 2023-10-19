<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
   
  
    #[Route('/show/{name}', name: 'show')]
    public function showAuthor($name): Response
    {  return $this->render('author/show.html.twig',
        [
           'name' => $name
       ]);
    }
    #[Route('/list', name: 'list')]

    public function list(): Response
    {  
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/list.html.twig',
        [
           'authors' => $authors
       ]);
    }
    public function authordetail($id): Response
    { $authorData = $this->getAuthorDataById($id);
        return $this->render('author/showAuthor.html.twig',
        [
           'author' => $authorData
       ]);
    }

    private function getAuthorDataById($id)
    {
        $authors = [
            1 => [
                'id' => 1,
                'picture' => '/images/Victor-Hugo.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100,
            ],
            2 => [
                'id' => 2,
                'picture' => '/images/william-shakespeare.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200,
            ],
            3 => [
                'id' => 3,
                'picture' => '/images/Taha_Hussein.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300,
            ],
        ];

        // Recherchez l'auteur par ID dans le tableau
        if (isset($authors[$id])) {
            return $authors[$id];
        }

        return null; // Retourne null si l'auteur n'est pas trouvé
    }

    // ...
}
