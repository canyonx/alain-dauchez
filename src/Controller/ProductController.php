<?php

namespace App\Controller;

use DateTime;
use App\Entity\Images;
use App\Entity\Peinture;
use App\Form\PeintureType;
use App\Repository\UserRepository;
use App\Repository\PeintureRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function list(
        PeintureRepository $peintureRepository
    ) {
        $product = $peintureRepository->findBy([], ['dateRealisation' => 'DESC']);

        return $this->render('product/list.html.twig', [
            'product' => $product,
            'auteur' => $this->auteur
        ]);
    }


    /**
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $em
    ) {
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
                ->setFile($product->getSlug() . '/')
                ->setUser($this->auteur)
                ->setCreatedAt(new DateTime());

            // si il y a des images transmises
            if ($form['images']->getData()) {

                //on crée le dossier
                //@mkdir(getcwd().$product)
                // On récupère les images transmises
                $images = $form['images']->getData();

                // On boucle sur les images
                foreach ($images as $k => $image) {
                    // On génère un nouveau nom de fichier
                    $fichier = $image->getClientOriginalName();
                    // dd($this->getParameter('upload_directory') . $product->getFile() . $fichier);

                    // si l'image existe dans le dossier on shunte
                    if (file_exists($this->getParameter('upload_directory') . $product->getFile() . $fichier)) {
                        continue;
                    }

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('upload_directory') . $product->getFile(),
                        $fichier
                    );

                    // On crée l'image dans la base de données
                    $img = new Images();
                    $img->setNom($fichier);
                    $product->addImage($img);

                    $em->persist($img);
                }
            }

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('show', [
                'slug' => $product->getSlug(),
                'w' => $product,
                'auteur' => $this->auteur
            ]);
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }


    /**
     * @Route("/admin/product/edit/{id}", name="product_edit")
     */
    public function edit(
        int $id,
        Request $request,
        PeintureRepository $peintureRepository,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ) {
        $product = $peintureRepository->findOneBy(['id' => $id]);
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
                ->setFile($product->getSlug() . '/')
                ->setUser($this->auteur);

            // si il y a des images transmises
            if ($form['images']->getData()) {

                //on crée le dossier
                //@mkdir(getcwd().$product)
                // On récupère les images transmises
                $images = $form['images']->getData();

                // On boucle sur les images
                foreach ($images as $k => $image) {
                    // On génère un nouveau nom de fichier
                    $fichier = $image->getClientOriginalName();
                    // dd($this->getParameter('upload_directory') . $product->getFile() . $fichier);

                    // si l'image existe dans le dossier on shunte
                    if (file_exists($this->getParameter('upload_directory') . $product->getFile() . $fichier)) {
                        continue;
                    }

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('upload_directory') . $product->getFile(),
                        $fichier
                    );

                    // On crée l'image dans la base de données
                    $img = new Images();
                    $img->setNom($fichier);
                    $product->addImage($img);

                    $em->persist($img);
                }
            }

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('show', [
                'slug' => $product->getSlug(),
                'w' => $product,
                'auteur' => $this->auteur
            ]);
        }

        return $this->render('product/edit.html.twig', [
            'p' => $product,
            'nbimages' => count(glob(getcwd() . '/img/' . $product->getFile() . "*.jpg")),
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }


    /**
     * @Route("/admin/product/delete/{id}", name="product_delete")
     */
    public function delete(
        int $id,
        PeintureRepository $peintureRepository,
        EntityManagerInterface $em
    ) {
        $product = $peintureRepository->findOneBy(['id' => $id]);

        // On Supprime un produit dans la bdd
        if ($product) {

            // supprime les images
            array_map('unlink', glob($this->getParameter('upload_directory') . $product->getFile() . '*.jpg'));
            // supprime le dossier
            rmdir($this->getParameter('upload_directory') . $product->getFile());

            $em->remove($product);
            $em->flush();
        }
        return $this->redirectToRoute('product_list');
    }
}
