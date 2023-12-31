<?php

namespace App\DataFixtures;

use App\Entity\Generique;
use App\Entity\Album;
use App\Entity\Member;
use App\Entity\Playlist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    // defines reference names for instances of Rack
    private const ALBUM_THOMAS = 'thomas-album';
    private const ALBUM_MAXIME = 'maxime-album';

    private const THOMAS = 'thomas';
    private const MAXIME = 'maxime';
    
    private const PLAYLIST_THOMAS_1 = 'thomas-playlist-1';
    private const PLAYLIST_THOMAS_2 = 'thomas-playlist-2';
    private const PLAYLIST_MAXIME_1 = 'maxime-playlist-1';    
    
    
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
    
    /**
     * Generates initialization data for album : [nom]
     * @return \\Generator
     */
    private static function memberDataGenerator()
    {
        yield ["thomas@localhost", "Schneider", "Thomas", null, self::THOMAS];
        yield ["maxime@localhost", "Sansané", "Maxime", "Crafteurmax", self::MAXIME];
    }
    
    private static function albumDataGenerator()
    {
        yield [self::THOMAS, "Album de génériques de Thomas", self::ALBUM_THOMAS];
        yield [self::MAXIME, "Les génériques de Maxime", self::ALBUM_MAXIME];
    }

    /**
     * Generates initialization data for generique recommendations:
     *  [film_title, film_year, recommendation]
     * @return \\Generator
     */
    private static function generiqueGenerator()
    {
        yield [self::ALBUM_THOMAS, "Oshi no Ko", "OP", 1,"Idol", "Yoasobi", self::PLAYLIST_THOMAS_1];
        yield [self::ALBUM_THOMAS, "Link Click", "ED", 1 , "Overthink", "Fan-Ka", self::PLAYLIST_THOMAS_2];
        yield [self::ALBUM_THOMAS, "Time Shadows", "OP", 2 , "Natsuyume Noisy", "Asaka", self::PLAYLIST_THOMAS_1];        
        yield [self::ALBUM_MAXIME, "Assassination Classroom", "OP", 4 , "Bye bye Yesterday", "3-nen E-gumi Utatan", null];
        yield [self::ALBUM_MAXIME, "Vinland Saga", "ED" , 3, "Without Love", "LMYK", self::PLAYLIST_MAXIME_1];
    }
    
    private static function playlistDataGenerator()
    {
        yield [self::THOMAS, "Opening", true, self::PLAYLIST_THOMAS_1];
        yield [self::THOMAS, "Ending",  false, self::PLAYLIST_THOMAS_2];
        yield [self::MAXIME, "Nani ?", true, self::PLAYLIST_MAXIME_1];
    }
    
    public function load(ObjectManager $manager)
    {
        $inventoryRepo = $manager->getRepository(Album::class);

        foreach (self::memberDataGenerator() as [$useremail, $nom, $prenom, $pseudo, $memberReference] ) {
            $member = new Member();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                $member->setUser($user);
            }
            $member->setNom($nom);
            $member->setPrenom($prenom);
            $member->setPseudo($pseudo);
            $manager->persist($member);
            $manager->flush();
            
            $this->addReference($memberReference, $member);
        }
        
        foreach (self::albumDataGenerator() as [$memberReference, $nom, $albumReference] )
        {
            $album = new Album();
            $album->setNom($nom);
            
            $manager->persist($album);
            
            $member = $this->getReference($memberReference);
            $member->addAlbum($album);
            
            $manager->flush(); 
            
            // Once the Album instance has been saved to DB
            // it has a valid Id generated by Doctrine, and can thus
            // be saved as a future reference
            $this->addReference($albumReference, $album);
        }
        
        foreach (self::playlistDataGenerator() as [$memberReference, $nom, $publiee, $playlistReference] )
        {
            $playlist = new Playlist();
            $playlist->setNom($nom);
            $playlist->setPubliee($publiee);
            
            // Retrieve the One-side instance of Album from its reference name
            $creator = $this->getReference($memberReference);
            // Add the Many-side Guitar to its containing rack
            $creator->addPlaylist($playlist);
            
            $this->addReference($playlistReference, $playlist);
            
            // Requir that the ORM\OneToMany attribute on Rack::guitars has "cascade: ['persist']"
            $manager->persist($playlist);
        }
        
        foreach (self::generiqueGenerator() as [$albumReference, $anime, $type , $numero, $titre, $artiste, $playlistReference] )
        {
            $generique = new Generique();
            $generique->setAnime($anime);
            $generique->setType($type);
            $generique->setNumero($numero);
            $generique->setTitre($titre);
            $generique->setArtiste($artiste);        
            
            // Retrieve the One-side instance of Album from its reference name
            $album = $this->getReference($albumReference);
            // Add the Many-side Guitar to its containing rack
            $album->addGenerique($generique);
            
            if ($playlistReference != null)
            {
                $playlist = $this->getReference($playlistReference);
                $playlist->addGenerique($generique);
            }

            // Requir that the ORM\OneToMany attribute on Rack::guitars has "cascade: ['persist']"
            $manager->persist($generique);
        }
        $manager->flush();
    }
}
