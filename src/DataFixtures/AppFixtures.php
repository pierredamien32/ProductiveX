<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Tache;
use App\Entity\Projet;
use App\Entity\Status;
use App\Entity\Employe;
use App\Entity\Entreprise;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Filesystem\Filesystem;

class AppFixtures extends Fixture
{

    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
    public function load(ObjectManager $manager): void
    {
        $filesystem = new Filesystem();
            //Utilisateur entreprise
        // Définir le répertoire de destination pour les images
        $kernel = new \App\Kernel('dev', true);
        $logoPath = $kernel->getProjectDir() . '/public' . '/uploads' . '/logo';

                // Vérifier si le dossier "logo" existe, sinon le créer
        if (!$filesystem->exists($logoPath)) {
            $filesystem->mkdir($logoPath);
        }

        $admin = new User();
        $admin->SetEmail('admin@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('admin123');

        $manager->persist($admin);

        //Utilisateur entreprise
        $entreprises = [];

        for ($i = 0; $i < 3; $i++) {

            $width = $this->faker->numberBetween(400, 800);
            $height = $this->faker->numberBetween(300, 600);
            $category = $this->faker->randomElement(['abstract', 'animals', 'business', 'food', 'nature']);
            $randomize = true;
            $word = $this->faker->word;
            $gray = false;
            $format = $this->faker->randomElement(['png', 'jpg']);
            $img = $this->faker->image($logoPath, $width, $height, $category, $randomize, $word, $gray, $format);
            
            $filename = basename($img);

            $entreprise = new Entreprise();
            $entreprise->setSigle($this->faker->companySuffix())
                ->setDenomination($this->faker->company())
                ->setLogo($filename)
                ->setAdresse($this->faker->address());
                
            $user = new User();
            $user->setEmail($this->faker->companyEmail())
                ->setNumtel($this->faker->phoneNumber())
                ->setPlainPassword('123456')
                ->setRoles(['ROLE_USER','ROLE_ENT']);
                $entreprise->setUser($user);

            $entreprises[] = $entreprise;
            $manager->persist($entreprise);
            $manager->persist($user);
        }


        //Employé
        $employes = [];

        for ($i = 0; $i < 10; $i++) {

            $width = $this->faker->numberBetween(400, 800);
            $height = $this->faker->numberBetween(300, 600);
            $category = $this->faker->randomElement(['abstract', 'animals', 'business', 'food', 'nature']);
            $randomize = true;
            $word = $this->faker->word;
            $gray = false;
            $format = $this->faker->randomElement(['png', 'jpg']);
            $img = $this->faker->image($logoPath, $width, $height, $category, $randomize, $word, $gray, $format);
            $filename = basename($img);

            $randomDated = $this->faker->dateTimeBetween('-20 years', '+0 days');
            $randomDateTimeImmutabled = new \DateTimeImmutable($randomDated->format('Y-m-d H:i:s'));
            
            $randomDatef = $this->faker->dateTimeBetween('-20 years', '+0 days');
            $randomDateTimeImmutablef = new \DateTimeImmutable($randomDatef->format('Y-m-d H:i:s'));

            $employe = new Employe();
            $employe->setNom($this->faker->name())
                ->setPoste($this->faker->jobTitle())
                ->setDebutcontratAt($randomDateTimeImmutabled)
                ->setEntreprise($entreprises[mt_rand(0, count($entreprises) - 1)])
                ->setFincontratAt($randomDateTimeImmutablef)
                ->setImage($filename);
                
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setNumtel($this->faker->phoneNumber())
                ->setPlainPassword('123456')
                ->setRoles(['ROLE_USER','ROLE_EMP']);
                $employe->setUser($user);

            $employes[] = $employe;
            $manager->persist($employe);
            $manager->persist($user);
        }

        
        //Status
        $statuss = [];
        $nomTabstatus = ['A faire', 'En cours', 'Terminé'];
        foreach ($nomTabstatus as $statusName) {
            $status = new Status();
            $status->setNom($statusName);
            $statuss[] = $status;
            $manager->persist($status);
        }

        //Projet
        $projets = [];
        for ($i = 0; $i < 5; $i++) {
            $projet = new Projet();
            
            // Générer une durée aléatoire
            $duree = new \DateInterval('P' . mt_rand(1, 10) . 'M'); // Durée de 1 à 10 mois, par exemple

            $projet->setNom('Prpject '. $this->faker->word())
                ->setDuree($duree)
                ->setDescription($this->faker->paragraph())
                ->setEntreprise($entreprises[mt_rand(0, count($entreprises) - 1)])
                ->setStatus($statuss[mt_rand(0, count($statuss) - 1)]);

            $projets[] = $projet;
            $manager->persist($projet);
        }      

        
         //Taches
        $taches = [];
        for ($i = 0; $i < 50; $i++) {
            $tache = new Tache();
            
            // Générer une durée aléatoire
            $duree = new \DateInterval('P' . mt_rand(1, 10) . 'M'); // Durée de 1 à 10 mois, par exemple

            $tache->setNom($this->faker->sentence())
                ->setDuree($duree)
                ->setDescription($this->faker->paragraph())
                ->setProjet($projets[mt_rand(0, count($projets) - 1)])
                ->setStatus($statuss[mt_rand(0, count($statuss) - 1)])
                ->setEmploye($employes[mt_rand(0, count($employes) - 1)])
                ;

            $taches[] = $tache;
            $manager->persist($tache);
        }      
        
        $manager->flush();
        
    }
}