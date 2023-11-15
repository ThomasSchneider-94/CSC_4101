<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Generique;
use App\Entity\Album;
use App\Form\GeneriqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/generique')]
class GeneriqueController extends AbstractController
{
    /*
    #[Route('/', name: 'generique_index', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $generiques = $entityManager->getRepository(Generique::class)->findAll();
        
        // dump($generiques);
        
        return $this->render('generique/index.html.twig',
            [ 'generiques' => $generiques ]
            );
    }
    */
    
    
    #[Route('/new/{id}', name: 'generique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Album $album): Response
    {
        $generique = new Generique();
        $album->addGenerique($generique);
        $form = $this->createForm(GeneriqueType::class, $generique);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($generique);
            $entityManager->flush();
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'Générique crée');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            
            return $this->redirectToRoute('generique_show', ['id' => $generique->getId()], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('generique/new.html.twig', [
            'generique' => $generique,
            'form' => $form,
        ]);
    }
    
    
    /**
     * Show a Generique
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/{id}', name: 'generique_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Generique $generique)
    {
        return $this->render('generique/show.html.twig',
            [ 'generique' => $generique ]
            );
    }
}
