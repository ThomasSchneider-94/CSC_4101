<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Album;
use App\Form\AlbumType;
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
        
        return $this->render('album/index.html.twig',
            [ 'albums' => $albums ]
            );
    }
    
    #[Route('/new', name: 'album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();
            
            return $this->redirectToRoute('album_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('playlist/new.html.twig', [
            'playlist' => $album,
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
