<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $em)
    {

        $user = $userRepository->getAuteur();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPrenom($form['prenom']->getData())
                ->setNom($form['nom']->getData())
                ->setTelephone($form['telephone']->getData())
                ->setAPropos($form['aPropos']->getData());

            // on récupère le fichier avatar
            if ($form['avatar']->getData()) {
                $file = $form['avatar']->getData();
                // suppression ancien avatar
                @unlink($this->getParameter('upload_directory') . '/avatar/' . $user->getAvatar());
                // Nouveau nom
                $fileName = uniqid("avatar-") . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory') . '/avatar', $fileName);
                $user->setAvatar($fileName);
            }

            // on récupère le fichier imageBg
            if ($form['imageBg']->getData()) {
                $file = $form['imageBg']->getData();
                // suppression ancien avatar
                @unlink($this->getParameter('upload_directory') . '/background/' . $user->getImageBg());
                // Nouveau nom
                $fileName = uniqid("imageBg-") . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory') . '/background', $fileName);
                $user->setImageBg($fileName);
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
