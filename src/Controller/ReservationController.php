<?php

namespace App\Controller;

use App\Entity\Resevation;
use App\Repository\HotelRepository;
use App\Repository\ReservationPanierRepository;
use App\Repository\ReservationRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReservationType;



/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{

    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     * @param ReservationRepository $repository
     * @return Response
     */
    public function index(ReservationRepository $repository): Response
    {

        return $this->render('reservation/afficher.html.twig', [
            'res' => $repository->findAll(),
        ]);
    }



    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Affiche", name="AfficheRes")
     */

    public function Affiche(ReservationRepository $repository)
    {
        $reservation = $repository -> findAll();
        return $this -> render('reservation/afficher.html.twig',['res' =>$reservation]);
    }


    /**
     * @param ReservationPanierRepository $repository
     * @return Response
     * @Route("/ListRQB" ,name="triePrix")
     */

    function OrderByDateQB(ReservationPanierRepository $repository)
    {
        $reservation = $repository->OrderByPrixQB();
        return $this->render('reservation/afficher.html.twig',['res' =>$reservation]);
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/supp",name="dR")
     */

    public function Delete($id,ReservationRepository $repository)
    {
        $reservation = $repository -> find($id);
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($reservation);
        $em -> flush();
        return $this -> redirectToRoute('reservation_index');

    }


    /**
     * @Route("/add" , name="res_new" , methods={"GET","POST"})
     */

    public function add(Request $request , SessionInterface $session)
    {
        $reservation = new Resevation();
        $form = $this -> createForm(ReservationType::class,$reservation);
        $form -> add('Ajouter',SubmitType::class);


        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> persist( $reservation);
            $em -> flush();
            return $this -> redirectToRoute('AfficheRes');
        }
        return $this -> render( 'reservation/Add.html.twig',[
            'form' => $form -> createView()
        ]);

    }


    /**
     * @param ReservationRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/{id}/edit",name="update")
     */

    public function Update(ReservationRepository $repository,$id,Request $request)
    {

        $reservation = $repository -> find($id);
        $form = $this -> createForm(ReservationType::class,$reservation);
        $form -> add('Modifier',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> flush();
            return $this -> redirectToRoute('reservation_index');
        }
        return $this -> render( 'reservation/Update.html.twig',[
            'UpdateF' => $form -> createView()
        ]);

    }


    /**
     * @param HotelRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/test",name="test")
     */

    function Test(HotelRepository $repository)
    {

        $hotel = $repository -> findAll();

        return $this -> render('hotel/afficherS.html.twig',['hotel' =>$hotel]);

    }

/*
    /**
     * @param ReservationRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/SarchPrix",name="search")
     */
/*
    function SearchPrix(ReservationRepository $repository,Request $request)
    {

        if($request->get("search") == null)
        {

            $reservation = $repository -> findAll();
        }else
        {
            $nsc =$request->get('search');
            $reservation = $repository->SearchPrixx($nsc);
        }

        return $this -> render('reservation/afficher.html.twig',['res' =>$reservation]);

    }

*/


    /**
     * @param ReservationRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/ListeByHotelQB",name="search")
     */

    function ListByHotelQB(ReservationRepository $repository,Request $request)
    {
        $q =$request->get("search");
        dd($q);
        if( q == null)
        {


            $reservation = $repository -> findAll();
        }else
        {
            $id =$request->get('search');
            $reservation = $repository->listReservationByHotel($id);
        }

        return $this -> render('reservation/afficher.html.twig',['res' =>$reservation]);

    }










}
