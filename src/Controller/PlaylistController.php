<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Generique;
use App\Entity\Member;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/playlist')]
class PlaylistController extends AbstractController
{
    #[Route('/', name: 'playlist_index', methods: ['GET'])]
    public function index(PlaylistRepository $playlistRepository): Response
    {
        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlistRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'playlist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Member $member): Response
    {
        $playlist = new Playlist();
        $playlist->setCreator($member);
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($playlist);
            $entityManager->flush();
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'Playlist créee');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()

            return $this->redirectToRoute('playlist_show', ['id' => $playlist->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'playlist_show', methods: ['GET'])]
    public function show(Playlist $playlist): Response
    {
        return $this->render('playlist/show.html.twig', [
            'playlist' => $playlist,
        ]);
    }

    #[Route('/{id}/edit', name: 'playlist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('playlist_show', ['id' => $playlist->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'playlist_delete', methods: ['POST'])]
    public function delete(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playlist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($playlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{playlist_id}/generique/{generique_id}', methods: ['GET'], name: 'playlist_generique_show')]
    public function generiqueShow(#[MapEntity(id: 'playlist_id')] Playlist $playlist,
        #[MapEntity(id: 'generique_id')] Generique $generique): Response
    {
        if(! $playlist->getGeneriques()->contains($generique)) {
            throw $this->createNotFoundException("Couldn't find such a [objet] in this [galerie]!");
        }
        
        if(! $playlist->isPubliee()) {
            throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        }
        
        return $this->render('playlist/generique_show.html.twig', [
            'generique' => $generique,
            'playlist' => $playlist
        ]);
    }
}
