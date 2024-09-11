<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;

class BooksiteController extends AbstractController
{ 
#[Route("/test-connection", name: "test_connection", methods: ["GET"])]
public function testConnection(ManagerRegistry $doctrine): Response
{
    $connection = $doctrine->getConnection();
    try {
        $connection->connect();
        if ($connection->isConnected()) {
            return new Response("Connected to the database successfully!");
        }
    } catch (\Exception $e) {
        return new Response("Could not connect to the database: " . $e->getMessage());
    }

    return new Response("Database connection test failed for an unknown reason.");
}




    #[Route("/", name: "book_index", methods: ["GET"])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render("booklist/index.html.twig", [
            "books" => $bookRepository->findAll(),
        ]);
    }

    #[Route("/new", name: "book_new", methods: ["GET", "POST"])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute("book_index");
        }

        return $this->render("booklist/new.html.twig", [
            "book" => $book,
            "form" => $form->createView(),
        ]);
    }

    #[Route("/{id}/edit", name: "book_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Book $book, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()
                ->flush();

            return $this->redirectToRoute("book_index");
        }

        return $this->render("booklist/edit.html.twig", [
            "book" => $book,
            "form" => $form->createView(),
        ]);
    }
    //Delete sub-section
    #[Route("/{id}", name: "book_delete", methods: ["DELETE"])]
    public function delete(Request $request, Book $book, ManagerRegistry $doctrine): Response
    {
    if ($this->isCsrfTokenValid("delete" . $book->getId(), $request->request->get("_token"))) {
    $entityManager = $doctrine->getManager();
    $entityManager->remove($book);
    $entityManager->flush();

    // Add a flash message to inform the user of the deletion
    $this->addFlash('success', 'The book has been deleted.');

    // Redirect back to the book index page
    return $this->redirectToRoute("book_index");
    }

    }

}
