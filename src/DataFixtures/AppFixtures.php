<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Entreprise;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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

        // Définir le répertoire de destination pour les images
        $kernel = new \App\Kernel('dev', true);
        $logoPath = $kernel->getProjectDir() . '/public' . '/uploads' . '/logo';

        $users = [];
        $entreprises = [];

        $admin = new User();
        $admin->SetEmail('admin@gmail.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPlainPassword('admin123');

        $users[] = $admin;
        $manager->persist($admin);

        for ($i = 0; $i < 5; $i++) {

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
                ->setRoles(['ROLE_USER']);
                $entreprise->setUserId($user);

            $users[] = $user;
            $entreprises[] = $entreprise;
            $manager->persist($entreprise);
            $manager->persist($user);
            $manager->flush();
        }
// ===============================================
    //    $entreprise = new Entreprise();
    //    $entreprise->setSigle('Entreprise #1')
    //         ->setDenomination('Denomination #1')
    //         ->setAdresse('Adresse #1');

    //     $user = new User();
    //     $user->setEmail($this->faker->email())
    //         ->setNumtel('NumTel #1')
    //         ->setPlainPassword('123456')
    //         ->setRoles(['ROLE_USER']);

    //     $entreprise->setUserId($user);
            
    //     $manager->persist($entreprise);
    //     $manager->persist($user);
        
    //     $manager->flush();
    }
}