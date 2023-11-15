<?php

namespace App\Form;

use App\Entity\Playlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\GeneriqueRepository;

class PlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $playlist = $options['data'] ?? null;
        $member = $playlist->getCreator();
        
        $builder
            ->add('nom')
            ->add('creator', null, [
                'disabled'   => true,
            ])
            ->add('publiee')
            ->add('generiques', null, [
            // avec 'by_reference' => false, sauvegarde les modifications
                'by_reference' => false,
                // classe pas obligatoire
                //'class' => [Object]::class,
                // permet sélection multiple
                'multiple' => true,
                // affiche sous forme de checkboxes
                'expanded' => true,
                
                'query_builder' => function (GeneriqueRepository $er) use ($member) {
                return $er->createQueryBuilder('o')
                ->leftJoin('o.album', 'i')
                ->andWhere('i.member = :member')
                ->setParameter('member', $member)
                ;
              }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
}
