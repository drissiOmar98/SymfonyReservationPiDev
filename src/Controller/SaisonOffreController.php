<?php

namespace App\Controller;

use App\Entity\Saisonoffre;
use App\Form\SaisonoffreType;
use App\Repository\OffreSaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SaisonOffreController extends AbstractController
{
    /**
     * @Route("/saison/offre", name="saison_offre")
     */
    public function index(): Response
    {
        return $this->render('saison_offre/index.html.twig', [
            'controller_name' => 'SaisonOffreController',
        ]);
    }
    /**
     * @param OffreSaisonRepository $repository
     * @return Response
     * @Route("/AfficheS", name="Affiches")
     */
    public function Affiche(OffreSaisonRepository $repository) :  Response
    {
        $saison = $repository -> findAll();

        return $this -> render('saison_offre/AfficherS.html.twig',['liste' =>$saison]);
    }
    /**
     * @param OffreSaisonRepository $repository
     * @return Response
     * @Route("/AfficheSeasonFront", name="AfficheSeasonFront")
     */
    public function AfficheS(OffreSaisonRepository $repository)
    {
        $saison = $repository -> findAll();

        return $this -> render('saison_offre/AfficherFrontS.html.twig',['liste' =>$saison]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/AddS")
     */
    public function add(Request $request)
    {
        $saison = new Saisonoffre();
        $form = $this -> createForm(SaisonoffreType::class,$saison);
        $form -> add('Ajouter',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> persist( $saison);
            $em -> flush();
            return $this -> redirectToRoute('Affiches');
        }
        return $this -> render( 'saison_offre/AddS.html.twig',[
            'form' => $form -> createView()
        ]);
    }
    /**
     * @param $id
     * @param OffreSaisonRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/supp/{id}",name="deleteS")
     */
    function Delete($id,OffreSaisonRepository  $repository){
        $saison=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($saison);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("Affiches");
    }

    /**
     * @param OffreSaisonRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/update/{id}",name="updateS")
     */
    public function Update(OffreSaisonRepository $repository,$id,Request $request)
    {

        $saison = $repository -> find($id);
        $form = $this -> createForm(SaisonoffreType::class,$saison);
        $form -> add('Modifier',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> flush();
            return $this -> redirectToRoute('Affiches');
        }
        return $this -> render( 'saison_offre/UpdateS.html.twig',[
            'form' => $form -> createView()
        ]);

    }
/*
    /**
     * @param OffreRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/saison/SarchSaison",name="searchSaison")
     */
/*
    function SearchSaison(OffreSaisonRepository $repository,Request $request)
    {
        if($request->get("searchS") == null)
        {

            $saison = $repository -> findAll();
        }else
        {
            $id =$request->get('searchS');
            $saison = $repository->SearchSaison($id);
        }

        return $this -> render('saison_offre/AfficherS.html.twig',['liste' =>$saison]);

    }

*/

    /**
     * @param OffreSaisonRepository $repository
     * @return Response
     * @Route("/ListDQL")
     */

    function OrderByTitleDQL(OffreSaisonRepository $repository)
    {
        $saison = $repository->OrderByTitleDQL();
        return $this->render('saison_offre/AfficherS.html.twig',['liste' =>$saison]);
    }

    /**
     * @param OffreSaisonRepository $repository
     * @return Response
     * @Route("/ListQB")
     */

    function OrderByTitleQB(OffreSaisonRepository $repository)
    {
        $saison = $repository->OrderByTitleQB();
        return $this->render('saison_offre/AffciherS.html.twig',['liste' =>$saison]);
    }

    /**
     * @param OffreSaisonRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/ListeByClassQB",name="searchSaison")
     */
    function ListByClassQB(OffreSaisonRepository $repository,Request $request)
    {


        if($request->get("searchS") == null)
        {

            $saison = $repository -> findAll();
        }else
        {
            $id =$request->get('searchS');
            $saison = $repository->listStudentByClass($id);
        }



        return $this -> render('saison_offre/AfficherS.html.twig',['liste' =>$saison]);

    }

    /**
     * @param OffreSaisonRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/ListeBySeasonQB",name="searchSaisonFront")
     */
    function ListBySeasonQB(OffreSaisonRepository $repository,Request $request)
    {


        if($request->get("searchS") == null)
        {

            $saison = $repository -> findAll();
        }else
        {
            $id =$request->get('searchS');
            $saison = $repository->listStudentByClass($id);
        }



        return $this -> render('saison_offre/AfficherFrontS.html.twig',['liste' =>$saison]);

    }











}
