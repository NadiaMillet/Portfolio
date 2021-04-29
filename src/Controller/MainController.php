<?php

namespace App\Controller;


use App\Entity\Profil;
use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class MainController extends AbstractController
{
    /////////////////////// VUE DE LA PAGE INDEX ONEPAGE ////////////////////////////////////
    /**
     * @Route("", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    ////////////////////////////////////// AFFICHER SECTION PROFIL /////////////////////////////////

    /**
     * @Route("", name="home" )
     */
    public function showprofil(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Profil::class);
        $profils = $repository->findAll();
        return $this->render('main/index.html.twig', ['profils' => $profils]);
    }

    ////////////////////// ACCUEIL ADMIN /////////////////////
    /**
     * @Route("admin", name="admin_home")
     */
    public function admin(): Response
    {
        return $this->render('admin/adminbord.html.twig');
    }

    ///////////////////// AJOUT PROFIL ///////////////////////
    /**
     * @Route("admin/newprofil", name="new_profil")
     */
    public function newprofil(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Profil::class);
        $profils = $repository->findAll();
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $profil->getImg();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $fileName);
            $profil->setImg($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);

            $em->flush();
        }

        return $this->render('/admin/profil/newprofil.html.twig', ['formProfil' => $form->createView(), 'profils' => $profils]);
    }

    ///////////////////////////////// MODIFIER LE PROFIL ///////////////////////////////////////////////
    /**
     * @Route("/admin/editprofil/{id<\d+>}", name="edit_profil")
     */
    public function editprofil(Request $request, Profil $profil)
    {
        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $profil->getImg();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move($this->getParameter('images_directory'), $fileName);

            $profil->setImg($fileName);

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('/admin/profil/editprofil.html.twig', ['formulaire' => $form->createView()]);
    }

    ////////////////////////////////////// AFFICHER LE PROFIL DANS L'ESPACE ADMIN /////////////////////////////////

    /**
     * @Route("/admin/showprofil", name="show_profil" )
     */
    public function listeprofil(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Profil::class);

        $profils = $repository->findAll();

        return $this->render('admin/profil/showprofil.html.twig', ['profils' => $profils]);
    }
}
