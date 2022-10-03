<?php

namespace App\Controller;

use App\Entity\DetailT;
use App\Entity\Transport;
use App\Form\DetailTType;
use App\Repository\DetailTRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DetailController extends AbstractController
{
    /**
     * @Route("/detail", name="detail")
     */
    public function index(): Response
    {
        return $this->render('detail/index.html.twig', [
            'controller_name' => 'DetailController',
        ]);
    }

    /**
     * @param DetailTRepository $repository
     * @return Response
     * @Route ("/afficherd",name="afficherd")
     */
    public function Affichedetail(DetailTRepository $repository){
        // $repo=$this->getDoctrine()->getRepository(Transport::class);
        $detail=$repository->findAll();
        return $this->render("detail/afficherdetail.html.twig",['detail'=>$detail]);
    }

    /**
     * @Route ("/Suppd/{id}",name="dt")
     */

    function Deleted($id,DetailTRepository $repository){
        //recuperer l'objet a suprrimer
        $detail=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($detail);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("afficherd");
}
    /**
     *
     * @Route ("/addd",name="ajoutdetailt")
     */
   public function addd (Request $request):Response{


        $detail=new DetailT();
        $detail->setDateCreation(new \DateTime());
        $detail->setDateModification(new \DateTime());

        $form=$this->createForm(DetailTType::class,$detail);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($detail);
            $em->flush();
            return $this->redirectToRoute('afficherd');
        }
        return $this->render('detail/addd.html.twig',[
            'form1'=>$form->createView()
        ]);

    }
    /**
     * @Route("detail/updated/{id}",name="updated")
     */

    function updated (DetailTRepository $repository, $id, Request $request){

        $detail =$repository->find($id);
        $form=$this->createForm(DetailTType::class,$detail);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return$this->redirectToRoute("afficherd");

        }

        return $this->render('detail/updated.html.twig',[
            'formd'=>$form->createView()
        ]);

    }
}

