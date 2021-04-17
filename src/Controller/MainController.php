<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    ////////////////////////////////////// AFFICHER LE PROFIL /////////////////////////////////

    /**
     * @Route("", name="home" )
     */
    public function show(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Profil::class);
        $profils = $repository->findAll();
        return $this->render('main/index.html.twig', ['profils' => $profils]);
    }



    ///////////////////// AJOUT PROFIL ///////////////////////
    /**
     * @Route("admin/newprofil", name="admin_bord")
     */
    public function new(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Profil::class);
        $profils = $repository->findAll();
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            ////////////////////////////// TEST 2 UPLOAD IMAGE YOUTUBE ROAD TO DEV //////////////////
            $file = $profil->getImg();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $fileName);
            $profil->setImg($fileName);

            // va recup la class dictrine -> va recuperer la class manager de données
            $em = $this->getDoctrine()->getManager();
            // em = objet intancier de la class manager (entity manager)
            // persist() = Cette méthode signale à Doctrine que l'objet doit être enregistré. Elle ne doit être utilisée que pour un nouvel objet et non pas pour une mise à jour.alors jutilise la methode persistante=persist pour rendre ($eleve) persistant 
            $em->persist($profil);
            // flush() = éxécute le SQL dans la base.
            $em->flush();
        }

        return $this->render('/admin/newprofil.html.twig', ['formProfil' => $form->createView(), 'profils' => $profils]);
    }

    ///////////////////////////////// MODIFIER LE PROFIL ///////////////////
    /**
     * @Route("/admin/editprofil/{id<\d+>}", name="edit")
     */
    public function edit(Request $request, Profil $profil)
    {
        $form = $this->createForm(ProduitType::class, $profil);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $profil->getImg();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move($this->getParameter('images_directory'), $fileName);

            $profil->setImg($fileName);

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('/admin/editprofil.html.twig', ['formulaire' => $form->createView()]);
    }

    ////////////////////////////////////// AFFICHER LE PROFIL DANS L'ESPACE ADMIN /////////////////////////////////

    /**
     * @Route("/admin/bord", name="admin_bord" )
     */
    // public function liste(Request $request)
    // {

    //     $repository = $this->getDoctrine()->getRepository(Profil::class);

    //     $profils = $repository->findAll();

    //     return $this->render('admin/bord.html.twig', ['profils' => $profils]);
    // }
}
