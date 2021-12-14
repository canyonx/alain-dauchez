<?php

namespace App\Controller;

use App\Form\NewPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordController extends AbstractController
{
    protected $auteur;

    public function __construct(UserRepository $userRepository)
    {
        $this->auteur = $userRepository->getAuteur();
    }


    /**
     * @Route("/admin/password/change/", name="password_change")
     */
    public function passwordChange(
        UserPasswordHasherInterface $encoder,
        EntityManagerInterface $em,
        Request $request
    ) {
        /**  @var User */
        $user = $this->getUser();
        $form = $this->createForm(NewPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Pass du form
            $password = $form["newPassword"]->getData();
            $hash = $encoder->hashPassword($user, $password);
            // Enregistre new password dans bdd
            $user->setPassword($hash);
            //$em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login', [
                'auteur' => $this->auteur
            ]);
        }

        return $this->render('password/new_password.html.twig', [
            'form' => $form->createView(),
            'auteur' => $this->auteur
        ]);
    }
}
