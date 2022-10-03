<?php

namespace App\Controller;

use App\Entity\ReservationPanier;
use App\Form\ReservationPanierType;
use App\Repository\EventsRepository;
use App\Repository\HotelRepository;
use App\Repository\OffreRepository;
use App\Repository\ReservationPanierRepository;
use App\Repository\TransportRepository;
use App\Repository\VolRepository;
use App\Service\QrCodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/reservation/panier")
 */
class ReservationPanierController extends AbstractController
{
    /**
     * @Route("/", name="reservation_panier_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {


        $reservation = $this->getDoctrine()
            ->getRepository(ReservationPanier::class)
            ->findAll();

        $reservation = $paginator->paginate(
            $reservation,
            $request->query->getInt('page',1),
            5
        );

        return $this->render('reservation_panier/index2.html.twig', [
            'reservation_paniers' => $reservation,
        ]);

    }


    /**
     * @Route("/new/{total}", name="reservation_panier_new", methods={"GET","POST"})
     */
    public function new(Request $request,$total, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $reservationPanier = new ReservationPanier();
        $form = $this->createForm(ReservationPanierType::class, $reservationPanier);
        $form->handleRequest($request);
       // $user = $this->getUser()->getId();
        //$username = $this->getUser()->getNom();

        if ($form->isSubmitted() && $form->isValid()) {
          //  $reservationPanier->setUserid($user);
           // $reservationPanier->setUsername($username);

            foreach ($panier as $key =>$value ) {
                $item[] = $key;
            }
           // dd($panier,$item);
            $reservationPanier->setItems($item);
            $reservationPanier->setPrix($total);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationPanier);
            $entityManager->flush();

            $id = $reservationPanier->getId();
            /**************** supp table painer *************///////
            foreach ($panier as $key =>$value ) {
               unset($panier[$key]); //dégommage
            }
            //////////****************************/////////////////

            $session->set('panier',$panier);
           //  dd($panier);


            return $this->redirectToRoute('reservation_panier_show2',['id'=>$id]);
           // return $this->redirectToRoute('cart_index');
        }
       // dd($panier);
        return $this->render('reservation_panier/new.html.twig', [
            'reservation_paniers' => $reservationPanier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newOffres/{total}", name="reservation_panier_newO", methods={"GET","POST"})
     */
    public function newOffres(Request $request,$total, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $reservationPanier = new ReservationPanier();
        $form = $this->createForm(ReservationPanierType::class, $reservationPanier);
        $form->handleRequest($request);
        // $user = $this->getUser()->getId();
        //$username = $this->getUser()->getNom();

        if ($form->isSubmitted() && $form->isValid()) {
            //  $reservationPanier->setUserid($user);
            // $reservationPanier->setUsername($username);

            foreach ($panier as $key =>$value ) {
                $item[] = $key;
            }
            // dd($panier,$item);
            $reservationPanier->setItems($item);
            $reservationPanier->setPrix($total);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationPanier);
            $entityManager->flush();

            $id = $reservationPanier->getId();
            /**************** supp table painer *************///////
            foreach ($panier as $key =>$value ) {
                unset($panier[$key]); //dégommage
            }
            //////////****************************/////////////////

            $session->set('panier',$panier);
            //  dd($panier);

            return $this->redirectToRoute('add_offer',['id'=>$id]);
            // return $this->redirectToRoute('cart_index');
        }
        // dd($panier);
        return $this->render('reservation_panier/new.html.twig', [
            'reservation_paniers' => $reservationPanier,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="reservation_panier_show", methods={"GET"})
     */
    public function show($id,ReservationPanier $reservationPanier,QrcodeService $service): Response
    {
        $ss =  $service->qrcodeH($id);
        return $this->render('reservation_panier/show.html.twig', [
            'reservation_panier' => $reservationPanier,'qrCode'=>$ss,
        ]);
    }

    /**
     * @Route("/off/{id}", name="reservation_panier_show2", methods={"GET"})
     */
    public function show2(Request $request,$id,ReservationPanierRepository $repository,QrcodeService $service): Response
    {
        $res = $repository->find($id);

        $ss =  $service->qrcodeH($id);
        return $this->render('reservation_panier/index.html.twig', [
            'reservation_paniers' => $res,'qrCode'=>$ss,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_panier_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ReservationPanier $reservationPanier
     * @return Response
     */
    public function edit(Request $request, ReservationPanier $reservationPanier): Response
    {
        $form = $this->createForm(ReservationPanierType::class, $reservationPanier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_panier_index');
        }

        return $this->render('reservation_panier/edit.html.twig', [
            'reservation_panier' => $reservationPanier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_panier_delete", methods={"DELETE"})
     * @param Request $request
     * @param ReservationPanier $reservationPanier
     * @return Response
     */
    public function delete(Request $request, ReservationPanier $reservationPanier): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationPanier);
            $entityManager->flush();

        return $this->redirectToRoute('reservation_panier_index');
    }



    /**
     * @Route("stat/", name="statRes")
     */
    public function stat(HotelRepository $hrepository,TransportRepository $trepository,VolRepository $vrepository ,OffreRepository $offreRepository,EventsRepository $eventsRepository){

        $reservation = $this->getDoctrine()->getRepository(ReservationPanier::class)->findAll();

       //  $pro = $this->getDoctrine()->getManager();

        $c1=0;
        $c2=0;
        $c3=0;
        $c4=0;
        $c5=0;

       //dd($reservation);

        foreach ($reservation as $res)
        {
            foreach ($res->getItems() as $item)
            {
                if($hrepository->find($item)):
                {
                    $c1+=1;
                }
                elseif ($trepository->find($item)):
                {
                    $c2+=1;
                }
                elseif ($vrepository->find($item)):
                {
                    $c3+=1;
                }elseif ($eventsRepository->find($item)):
                {
                    $c4+=1;
                }elseif ($offreRepository->find($item)):
                {
                    $c5+=1;
                }
                endif;
            }
        }

        // dd( $produit,$c1,$c2,$c3);

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Nombre'],
                ['Hotels',  $c1],
                ['Transports',  $c2],
                ['Volls',  $c3],
                ['Events',  $c4],
                ['Offres',  $c5],
            ]
        );

        $pieChart->getOptions()->setTitle('Top Catégories');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('reservation_panier/stat.html.twig', array('div_chart' => $pieChart));
    }

    /**
     * @param ReservationPanierRepository $repository
     * @return Response
     * @Route("/tt/ListRQB" ,name="trieP")
     */
    function OrderByDateQB(Request $request,QrCodeService $service,ReservationPanierRepository $repository)
    {
      //  $ss =  $service->qrcode2(1);
        $reservation = $repository->OrderByPrix();
        return $this->render('reservation_panier/index3.html.twig', [
            'reservation_paniers' => $reservation,
        ]);
    }

    /**
     * @Route("/searchReservation ", name="searchReser")
     */
    public function searchReservation(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $requestString=$request->get('searchValue');
        $res = $repository->findReservationByNsc($requestString);
        $jsonContent = $Normalizer->normalize($res, 'json',['groups'=>'reservation']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }



}
