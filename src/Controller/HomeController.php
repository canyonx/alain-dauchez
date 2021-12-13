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
    protected $auteur;

    public function __construct(UserRepository $userRepository)
    {
        $this->auteur = $userRepository->getAuteur();
    }

    /**
     * @Route("/", name="home")
     */
    public function index(PeintureRepository $peintureRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'work' => $peintureRepository->findBy([], ['dateRealisation' => 'DESC'], 3),
            'auteur' => $this->auteur
        ]);
    }

    /**
     * @Route("/sculpture/{slug}", name="show")
     */
    public function show(string $slug, PeintureRepository $peintureRepository)
    {
        $sculpture = $peintureRepository->findOneBy(['slug' => $slug]);

        return $this->render('home/show.html.twig', [
            'w' => $sculpture,
            'nbimages' => count(glob(getcwd() . '/img/' . $sculpture->getFile() . "*.jpg")),
            'auteur' => $this->auteur
        ]);
    }

    /**
     * @Route("/realisations", name="work")
     */
    public function work(PeintureRepository $peintureRepository, PaginatorInterface $paginator, Request $request)
    {
        $data = $peintureRepository->findBy([], ['dateRealisation' => 'DESC']);

        $work = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('home/work.html.twig', [
            'work' => $work,
            'auteur' => $this->auteur
        ]);
    }
}
