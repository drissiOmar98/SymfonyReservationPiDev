<?php

namespace App\Controller;

use App\Entity\Banque;
use App\Entity\Books;
use App\Form\BanqueType;
use App\Form\BooksType;
use App\Repository\BanqueRepository;
use App\Repository\BooksRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;


class BanqueController extends AbstractController
{
    /**
     * @Route("/banque", name="banque")
     */
    public function index(): Response
    {
        return $this->render('banque/index.html.twig', [
            'controller_name' => 'BanqueController',
        ]);
    }

    /**
     * @param BanqueRepository $repository
     * @return Response
     * @Route ("BanqueAffB",name="affB")
     */
    public function Affiche(BanqueRepository $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $banque=$repository->findAll();
        return $this->render("Banque/afficherB.html.twig",['banque'=>$banque]);
    }

    /**
     * @param BanqueRepository $repository
     * @Route ("BanqueSupp/{id}",name="dB")
     * @return Response
     */
    function Delete($id,BanqueRepository $repository){
        //recuperer l'objet a suprrimer
        $banque=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($banque);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("affB");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("BanqueAdd", name="ajoutB")
     */
    function ADD(Request $request ){
        $banque=new Banque();
        $form=$this->createForm(BanqueType::class,$banque);
        $form->add('Ajouter',SubmitType::class);
        $form -> handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($banque);
            $em->flush();
            return $this->redirectToRoute('affB');
        }
        return $this->render('Banque/AddB.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("BanqueUpdate/{id}",name="updateB")
     */
    function Update(BanqueRepository $repository,$id,Request $request){
        $banque=$repository->find($id);
        $form=$this->createForm(BanqueType::class,$banque);
        $form->add('Update',SubmitType::class );
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affB');
        }
        return $this->render('Banque/UpdateB.html.twig',[
            'form'=>$form->createView()

        ]);
    }

    /**
     * @param BanqueRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("BanqueRech",name="rechercheB")
     */
    function Recherche(BanqueRepository $repository,Request $request){
        $data=$request->get('search');
        $banque=$repository->findBy(['id'=>$data]);
        return $this->render("Banque/afficherB.html.twig",['banque'=>$banque]);
    }
    /**
     * @param BanqueRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("BanqueVerif",name="Verif")
     */
    function Paiement(BanqueRepository $repository,Request $request){
        $data=$request->get('search');
        $verif=$repository->findBy(['code'=>$data]);

        return $this->render("Banque/afficherP.html.twig",['verif'=>$verif]);
    }
}
