<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Album;
use App\Form\AlbumType;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/album')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'album_index', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $albums = $entityManager->getRepository(Album::class)->findAll();
        
        // dump($albums);
        // Make sure message will be displayed after redirect
        $this->addFlash('message', 'Album crée');
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        
        return $this->render('album/index.html.twig',
            [ 'albums' => $albums ]
            );
    }
    
    
    #[Route('/new/{id}', name: 'album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Member $member): Response
    {
        $album = new Album();
        $album->setMember($member);
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();
            
            return $this->redirectToRoute('album_show', ['id' => $album->getId()], Response::HTTP_SEE_OTHER);
        }                                                  
        
        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }
    
    /**
     * Show a Album
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/{id}', name: 'album_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Album $album)
    {
        return $this->render('album/show.html.twig',
            [ 'album' => $album ]
            );
    }
}
