<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
       
    }
    
    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */

    
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        //$properties = $repository->findLatest();
        $properties = $paginator->paginate(
            $this->repository->findLatest(),
            $request->query->getInt('page', 1),
            6);
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}