<?php

namespace App\Controller;

use DateTime;
use App\Entity\Peinture;
use App\Form\PeintureType;
use App\Repository\UserRepository;
use App\Repository\PeintureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    protected $auteur;

    public function __construct(UserRepository $userRepository)
    {
        $this->auteur = $userRepository->getAuteur();
    }

    /**
     * @Route("/admin", name="product_list")
     */
    public function list(PeintureRepository $peintureRepository): Response
    {
        $product = $peintureRepository->findBy([], ['createdAt' => 'ASC']);

        return $this->render('product/list.html.twig', [
            'product' => $product,
            'auteur' => $this->auteur
        ]);
    }

    /**
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Peinture();
        $form = $this->createForm(PeintureType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setNom($form['nom']->getData())
                ->setHauteur($form['hauteur']->getData())
                ->setLargeur($form['largeur']->getData())
                ->setDateRealisation($form['dateRealisation']->getData())
                ->setPrix($form['prix']->getData())
                ->setEnVente($form['enVente']->getData())
                ->setPortfolio(true)
                ->setDescription($form['description']->getData())
                ->setSlug(strtolower($slugger->slug($product->getNom())))
                ->setFile('/' . $product->getSlug())
                ->setUser($this->auteur)
                ->setCreatedAt(new DateTime());
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }

    /**
     * @Route("/admin/product/edit", name="product_edit")
     */
    public function edit(): Response
    {
        return $this->render('product/edit.html.twig', []);
    }

    /**
     * @Route("/admin/product/delete", name="product_delete")
     */
    public function delete(): Response
    {
        return $this->render('product/delete.html.twig', []);
    }
}
