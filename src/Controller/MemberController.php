<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Member;

#[Route('/member')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'member_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();
        
        // dump($members);
        
        return $this->render('member/index.html.twig',
            [ 'members' => $members ]
            );
    }
    
    #[Route('/{id}', name: 'member_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Member $member)
    {
        return $this->render('member/show.html.twig',
            [ 'member' => $member ]
            );
    }
    
}
