<?php

namespace App\Controller;

use App\Controller\Upload\UploadImageService;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    protected $auteur;

    public function __construct(UserRepository $userRepository)
    {
        $this->auteur = $userRepository->getAuteur();
    }

    /**
     * @Route("/admin/profil/edit", name="profil_edit")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UploadImageService $uploadImageService
    ) {

        $form = $this->createForm(UserType::class, $this->auteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->auteur->setPrenom($form['prenom']->getData())
                ->setNom($form['nom']->getData())
                ->setEmail($form['email']->getData())
                ->setTelephone($form['telephone']->getData())
                ->setSousTitre($form['sousTitre']->getData())
                ->setAPropos($form['aPropos']->getData());

            // on récupère le fichier background
            if ($form['background']->getData()) {
                // suppression des images du dossier
                @array_map('unlink', glob($this->getParameter('upload_directory') . 'background' . "/*.jpg"));
                // upload de l'image
                $fileName = $uploadImageService->singleImage($form['background']->getData(), 'background');
                // enregistrement du nom dans la bdd
                $this->auteur->setBackground($fileName);
            }

            // on récupère le fichier avatar
            if ($form['avatar']->getData()) {
                // suppression des images du dossier
                @array_map('unlink', glob($this->getParameter('upload_directory') . 'avatar' . "/*.jpg"));
                // upload de l'image
                $fileName = $uploadImageService->singleImage($form['avatar']->getData(), 'avatar');
                // enregistrement du nom dans la bdd
                $this->auteur->setAvatar($fileName);
            }

            clearstatcache();

            $em->flush();


            return $this->redirectToRoute('home');
        }


        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }
}
