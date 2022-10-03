<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Lieu;
use App\Form\HotelType;
use App\Form\LieuType;
use App\Repository\HotelRepository;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     */
    public function index(): Response
    {
        return $this->render('lieu/index.html.twig', [
            'controller_name' => 'LieuController',
        ]);
    }

    /**
     * @param LieuRepository $repository
     * @return Response
     * @Route ("/affLieu",name="affLieu")
     */
    public function Affiche(LieuRepository $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $lieu=$repository->findAll();
        return $this->render("lieu/afficher.html.twig",['lieu'=>$lieu]);
    }

    /**
     * @Route ("/SuppLieu/{id}",name="delLieu")
     */
    function Delete($id,LieuRepository $repository){
        $lieu=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($lieu);
        $em->flush();
        return $this->redirectToRoute('affLieu');
    }
    /**
     * @param Request $request
     * @return Response
     * @Route ("/AddLieu",name="AddLieu")
     */
    function  Add(Request $request){
        $lieu = new Lieu();
        $form=$this->createForm(LieuType::class,$lieu);
        $form->add('ajouter',SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('affLieu');
        }
        return $this->render('lieu/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route ("/lieu/Update/{id}",name="miseLieu")
     */
    function Update(LieuRepository $repository,$id,Request $request){
        $lieu=$repository->find($id);
        $form=$this ->createForm(LieuType::class,$lieu);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);



        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affLieu");
        }
        return $this->render('lieu/updateL.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param LieuRepository $repository
     * @Route ("lieu/recherche",name="rechercheLieu")
     */
    function Recherche(LieuRepository $repository,Request $request){
        $data=$request->get('search');

        $lieu=$repository->findBy(['lieux'=>$data]);
        return $this->render("lieu/afficher.html.twig",['lieu'=>$lieu]);


    }
}
