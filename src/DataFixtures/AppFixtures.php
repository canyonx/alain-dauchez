<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Peinture;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail('dauchez.alain@gmail.com')
            ->setNom('Dauchez')
            ->setPrenom('Alain')
            ->setPassword($this->encoder->hashPassword($admin, 'admin'))
            ->setAPropos($faker->sentence($nbWords = 40, $variableNbWords = true))
            ->setTelephone('07 61 92 37 82')
            ->setRoles(['ROLE_AUTEUR']);

        $manager->persist($admin);

        $categorie = new Categorie();
        $categorie->setNom('Sculpture sur bois')
            ->setDescription($faker->sentence($nbWords = 40, $variableNbWords = true))
            ->setSlug(strtolower($this->slugger->slug($categorie->getNom())));

        $manager->persist($categorie);


        for ($i = 0; $i < 12; $i++) {
            $sculpture = new Peinture();
            $sculpture->setNom('Danse')
                ->setUser($admin)
                ->setSlug(strtolower($this->slugger->slug($sculpture->getNom())))
                ->setFile('/img/' . strtolower($sculpture->getNom()) . '/')
                ->setHauteur(11000)
                ->setLargeur(11000)
                ->setPrix(1200000)
                ->setPortfolio(true)
                ->setEnVente(true)
                ->setDescription($faker->sentence($nbWords = 40, $variableNbWords = true))
                ->setCreatedAt(new DateTime())
                ->addCategorie($categorie);

            $manager->persist($sculpture);
        }

        $manager->flush();
    }
}
