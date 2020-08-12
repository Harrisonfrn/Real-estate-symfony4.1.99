<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index()
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/profil/edit", name="profil_edit")
     */
    public function edit(Request $request)
    {
        $users = $this->getUser();

        $form = $this->createForm(EditProfilType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            $this->addFlash('message', 'Profil mis a jour');
            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/editPass", name="profil_edit_pass")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $users = $this->getUser();

            //On verifie si les deux mdp sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $users->setPassword($passwordEncoder->encodePassword($users, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis a jour');

                return $this->redirectToRoute('profil');
            } else {
                $this->addFlash('error', 'les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('profil/editPass.html.twig');
    }

    /**
     * Affichage des biens sauvegardé
     * @Route("/profil/favoris", name="profil_likedProperty")
     *
     * @return void
     */
    public function likedProperty()
    {

        return $this->render('profil/likedProperty.html.twig');
    }
}
