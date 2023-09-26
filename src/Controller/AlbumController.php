<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AlbumRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Album;

class AlbumController extends AbstractController
{
    #[Route('/album', name: 'app_album', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste de mes albums!</title>
    </head>
    <body>Liste des Albums :
        <ul>';
        $albums = $albumRepository->findAll();
        foreach($albums as $album) {
            $htmlpage .= '<li>'. $album->getDescription() .'</li>';
        }
        /*
        $entityManager= $doctrine->getManager();
        $albums = $entityManager->getRepository(Album::class)->findAll();
        foreach($albums as $album) {
            $url = $this->generateUrl(
                'album_show',
                ['id' => $album->getId()]);
            $htmlpage .= '<li>
            <a href="'. $url .'">'. $album->getDescription() .'</a></li>';
        }
        */
        $htmlpage .= '</ul>';
        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
    
    /**
     * Show a [inventaire]
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/album/{id}', name: 'album_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $albumRepo = $doctrine->getRepository(Album::class);
        $album = $albumRepo->find($id);
        
        if (!$album) {
            throw $this->createNotFoundException('L\'album n\'existe pas');
        }
        
        $res = '...';
        $entityManager= $doctrine->getManager();
        $albums = $entityManager->getRepository(Album::class)->findAll();
        foreach($albums as $album) {
            $url = $this->generateUrl(
                'album_show',
                ['id' => $album->getId()]);
            $res .= '<li>
            <a href="'. $url .'">'. $albums->getDescription() .'</a></li>';
        }
        
        
        
        
        //...
        
        $res .= '<p/><a href="' . $this->generateUrl('album_index') . '">Back</a>';
        
        return new Response('<html><body>'. $res . '</body></html>');
    }
}
