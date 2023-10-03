<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Generique;

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
