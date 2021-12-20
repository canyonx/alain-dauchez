<?php

namespace App\Controller;

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
        EntityManagerInterface $em
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


            // on récupère le fichier avatar
            if ($form['avatar']->getData()) {

                $file = $form['avatar']->getData();
                // suppression ancien avatar
                @unlink($this->getParameter('upload_directory') . '/avatar/' . $this->auteur->getAvatar());
                // Nouveau nom
                $fileName = "avatar" . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory') . '/avatar', $fileName);
                $this->auteur->setAvatar($fileName);
            }

            // on récupère le fichier imageBg
            if ($form['imageBg']->getData()) {
                $file = $form['imageBg']->getData();
                // suppression ancien avatar
                @unlink($this->getParameter('upload_directory') . '/background/' . $this->auteur->getImageBg());
                // Nouveau nom
                $fileName = "imageBg" . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory') . '/background', $fileName);
                $this->auteur->setImageBg($fileName);
                clearstatcache();
            }

            $em->flush();


            return $this->redirectToRoute('home');
        }


        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }
}
