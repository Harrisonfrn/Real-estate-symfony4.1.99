<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertyLike;
use App\Entity\Search;
use App\Form\ContactType;
use App\Form\SearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyLikeRepository;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render("property/index.html.twig", [
            'current_menu'      => 'properties',
            'properties'        => $properties,
            'form'              => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $contactNotification): Response
    {

        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactNotification->notify($contact);
            $this->addFlash('success', 'Votre email bien été envoyé');

            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render("property/show.html.twig", [
            'property'          => $property,
            'current_menu'      => 'properties',
            'form'              => $form->createView()
        ]);
    }

    /**
     * Permet de liker ou unliker un biens
     *
     * @Route("biens/{id}/like", name="property.like")
     * 
     * @param Property $property
     * @param ObjectManager $objectManager
     * @param PropertyLikeRepository $likeRepo
     * @return Response
     */
    public function like(Property $property, EntityManagerInterface $em, PropertyLikeRepository $likeRepo): Response
    {
        $users = $this->getUser();

        if (!$users) {
            return $this->json([
                'code' => 403,
                'error' => 'Vous devez être connecter pour aimer un biens'
            ]);
        }

        if ($property->isLikedByUser($users)) {
            $like = $likeRepo->findOneBy([
                'property' => $property,
                'user' => $users
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
            ], 200);
        }

        $like = new PropertyLike();
        $like->setProperty($property)
            ->setUser($users);

        $em->persist($like);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'bien liker'
        ], 200);
    }
}
