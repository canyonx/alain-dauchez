<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Peinture;
use App\Entity\Categorie;
use PHPUnit\Framework\TestCase;

class PeintureTest extends TestCase
{
    public function testIsTrue()
    {
        $peinture = new Peinture();
        $datetime = new DateTime();
        $categorie = new Categorie();
        $user = new User();

        $peinture->setNom('nom')
            ->setLargeur(1000)
            ->setHauteur(1000)
            ->setEnVente(True)
            ->setPortfolio(True)
            ->setPrix(1000)
            ->setCreatedAt($datetime)
            ->setDescription('description')
            ->setSlug('slug')
            ->addCategorie($categorie)
            ->setFile('file')
            ->setUser($user);

        $this->assertTrue($peinture->getNom() === 'nom');
        $this->assertTrue($peinture->getLargeur() === 1000);
        $this->assertTrue($peinture->getHauteur() === 1000);
        $this->assertTrue($peinture->getEnVente() === True);
        $this->assertTrue($peinture->getPortfolio() === True);
        $this->assertTrue($peinture->getPrix() === 1000);
        $this->assertTrue($peinture->getCreatedAt() === $datetime);
        $this->assertTrue($peinture->getDescription() === 'description');
        $this->assertTrue($peinture->getSlug() === 'slug');
        $this->assertContains($categorie, $peinture->getCategorie());
        $this->assertTrue($peinture->getFile() === 'file');
        $this->assertTrue($peinture->getUser() === $user);
    }

    public function testIsFalse()
    {
        $peinture = new Peinture();
        $datetime = new DateTime();
        $categorie = new Categorie();
        $user = new User();

        $peinture->setNom('nom')
            ->setLargeur(1000)
            ->setHauteur(1000)
            ->setEnVente(true)
            ->setPortfolio(true)
            ->setPrix(1000)
            ->setCreatedAt($datetime)
            ->setDescription('description')
            ->setSlug('slug')
            ->addCategorie($categorie)
            ->setFile('file')
            ->setUser($user);

        $this->assertFalse($peinture->getNom() === false);
        $this->assertFalse($peinture->getLargeur() === false);
        $this->assertFalse($peinture->getHauteur() === false);
        $this->assertFalse($peinture->getEnVente() === false);
        $this->assertFalse($peinture->getPortfolio() === false);
        $this->assertFalse($peinture->getPrix() === false);
        $this->assertFalse($peinture->getCreatedAt() === false);
        $this->assertFalse($peinture->getDescription() === 'false');
        $this->assertFalse($peinture->getSlug() === 'false');
        $this->assertNotContains(new Categorie(), $peinture->getCategorie());
        $this->assertFalse($peinture->getFile() === 'false');
        $this->assertFalse($peinture->getUser() === false);
    }

    public function testIsEmpty()
    {
        $peinture = new Peinture();



        $this->assertEmpty($peinture->getNom());
        $this->assertEmpty($peinture->getLargeur());
        $this->assertEmpty($peinture->getHauteur());
        $this->assertEmpty($peinture->getEnVente());
        $this->assertEmpty($peinture->getPortfolio());
        $this->assertEmpty($peinture->getPrix());
        $this->assertEmpty($peinture->getCreatedAt());
        $this->assertEmpty($peinture->getDescription());
        $this->assertEmpty($peinture->getSlug());
        $this->assertEmpty($peinture->getCategorie());
        $this->assertEmpty($peinture->getFile());
        $this->assertEmpty($peinture->getUser());
    }
}
