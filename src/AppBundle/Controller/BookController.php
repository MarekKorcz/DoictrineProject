<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Book;

class BookController extends Controller
{
    /**
     * @Route("/newBook")
     */
    public function newBookAction()
    {
        return $this->render('AppBundle:Book:new_book.html.twig');
    }
    
    /**
     * @Route("/createBook")
     * @Method("POST")
     */
    public function createBookAction(Request $req){
        $em = $this->getDoctrine()->getManager();
        
        $title = $req->request->get("title", "No title");
        $desc = $req->request->get("description", "No description");
        $raiting = (float)$req->request->get("raiting", 0.0);
        
        $newBook = new Book();
        $newBook->setDescription($desc);
        $newBook->setRaiting($raiting);
        $newBook->setTitle($title);
        
        $em->persist($newBook);
        $em->flush();
        
        
        
        return $this->redirectToRoute(
                "app_book_showbook", 
                ["id" => $newBook->getId()]);
    }
    
    /**
     * @Route("/showBook/{id}")
     * @Method("GET")
     */
    public function showBookAction($id){
        $repo = $this->getDoctrine()->getRepository("AppBundle:Book");
        $book = $repo->find($id);
        
        return $this->render(
                "AppBundle:Book:show_book.html.twig",
                ["bookToShow" => $book]
                );
    }
    
    /**
     * @Route("/showAllBooks")
     * @Method("GET")
     */
    public function showAllBooksAction(){
        $repo = $this->getDoctrine()
                     ->getRepository("AppBundle:Book");
        $allBooks = $repo->findAll();
        
        return $this->render("AppBundle:Book:list_book.html.twig",
                ["allBooks" => $allBooks]
                );
    }
    
    /**
     * @Route("/deleteBook/{id}")
     */
    public function deleteBookAction($id){
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository("AppBundle:Book");
        
        $bookToDelete = $repo->find($id);
        
        if($bookToDelete != null){
            $em->remove($bookToDelete);
            $em->flush();
        }
        
        return $this->redirectToRoute("app_book_showallbooks");
    }

}
