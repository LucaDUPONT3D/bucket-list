<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Utils\Censurator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {

        $wishes = $wishRepository->findPublishedWishes();

        return $this->render('wish/list.html.twig', ["wishes"=>$wishes]);
    }

    #[Route('/{id}', name: 'show' , requirements: ["id" => "\d+"])]
    public function detail(Wish $id): Response
    {
        return $this->render('wish/detail.html.twig', ["wish"=>$id]);
    }

    #[Route('/add', name: 'add')]
    public function add(WishRepository $wishRepository, Request $request, Censurator $censurator): Response
    {

        $wish = new Wish();
        $wish->setAuthor($this->getUser()->getUserIdentifier());
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {

            $wish->setTitle($censurator->purify($wish->getTitle()));
            $wish->setDescription($censurator->purify($wish->getDescription()));

            $wishRepository->save($wish, true);

            $this->addFlash('success', "Wish added !");

            return $this->redirectToRoute('wish_show', ['id' => $wish->getId()]);
        }

        return $this->render('wish/add.html.twig', ['wishForm'=> $wishForm->createView()]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(WishRepository $wishRepository, Request $request, Wish $id, Censurator $censurator): Response
    {
        $wish = $wishRepository->find($id->getId());

        if (!$wish){
            throw $this->createNotFoundException("Oops ! Wish not found !");
        }
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {

            $wish->setTitle($censurator->purify($wish->getTitle()));
            $wish->setDescription($censurator->purify($wish->getDescription()));

            $wishRepository->save($wish, true);

            $this->addFlash('success', "Wish Updated !");

            return $this->redirectToRoute('wish_show', ['id' => $wish->getId()]);
        }
        return $this->render('wish/update.html.twig', ['wishForm'=> $wishForm->createView(), 'wish'=>$wish]);
    }
}
