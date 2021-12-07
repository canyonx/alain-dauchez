<?php

namespace App\Tests;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Peinture;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommentaireTest extends TestCase
{
    public function testIsTrue()
    {
        $commentaire = new Commentaire();
        $datetime = new DateTime();
        $blogpost = new Blogpost();
        $peinture = new Peinture();

        $commentaire->setAuteur('nom')
            ->setContenu('description')
            ->setEmail('true@true.com')
            ->setCreatedAt($datetime)
            ->setBlogpost($blogpost)
            ->setPeinture($peinture);

        $this->assertTrue($commentaire->getAuteur() === 'nom');
        $this->assertTrue($commentaire->getContenu() === 'description');
        $this->assertTrue($commentaire->getEmail() === 'true@true.com');
        $this->assertTrue($commentaire->getCreatedAt() === $datetime);
        $this->assertTrue($commentaire->getBlogpost() === $blogpost);
    }

    public function testIsFalse()
    {
        $commentaire = new Commentaire();
        $datetime = new DateTime();
        $blogpost = new Blogpost();
        $peinture = new Peinture();

        $commentaire->setAuteur('nom')
            ->setContenu('description')
            ->setEmail('true@true.com')
            ->setCreatedAt($datetime)
            ->setBlogpost(new Blogpost())
            ->setPeinture(new Peinture());

        $this->assertFalse($commentaire->getAuteur() === 'false');
        $this->assertFalse($commentaire->getContenu() === 'false');
        $this->assertFalse($commentaire->getEmail() === 'false');
        $this->assertFalse($commentaire->getCreatedAt() === new DateTime());
        $this->assertFalse($commentaire->getBlogpost() === $blogpost);
        $this->assertFalse($commentaire->getPeinture() === $peinture);
    }

    public function testIsEmpty()
    {
        $commentaire = new Commentaire();

        $this->assertEmpty($commentaire->getAuteur());
        $this->assertEmpty($commentaire->getContenu());
        $this->assertEmpty($commentaire->getEmail());
        $this->assertEmpty($commentaire->getCreatedAt());
        $this->assertEmpty($commentaire->getBlogpost());
        $this->assertEmpty($commentaire->getPeinture());
    }
}
