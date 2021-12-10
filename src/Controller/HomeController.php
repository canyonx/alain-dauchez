<?php

namespace App\Controller;

use App\Repository\PeintureRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PeintureRepository $peintureRepository, UserRepository $userRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'work' => $peintureRepository->findBy([], [], 3),
            'auteur' => $userRepository->findOneBy(['prenom' => 'Alain'])
        ]);
    }

    /**
     * @Route("/sculpture/{slug}", name="show")
     */
    public function show(string $slug, PeintureRepository $peintureRepository)
    {
        return $this->render('home/show.html.twig', [
            'w' => $peintureRepository->findOneBy(['slug' => $slug]),
        ]);
    }

    /**
     * @Route("/realisations", name="work")
     */
    public function work(PeintureRepository $peintureRepository, PaginatorInterface $paginator, Request $request)
    {
        $data = $peintureRepository->findAll();

        $work = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('home/work.html.twig', [
            'work' => $work
        ]);
    }
}
