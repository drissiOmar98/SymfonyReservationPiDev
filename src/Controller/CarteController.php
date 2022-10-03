<?php

namespace App\Controller;



use App\Entity\Events;
use App\Entity\Hotel;
use App\Entity\Offre;
use App\Entity\Transport;
use App\Entity\Vol;
use App\Repository\EventsRepository;
use App\Repository\HotelRepository;
use App\Repository\OffreRepository;
use App\Repository\TransportRepository;
use App\Repository\VolRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;



class CarteController extends AbstractController
{
    /**
     * @Route("/carte", name="cart_index")
     * @param Request $request
     * @param SessionInterface $session
     * @param FlashyNotifier $flashy
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session,FlashyNotifier $flashy, HotelRepository $hotelRepository,TransportRepository $transportRepository ,OffreRepository $offresRepository ,VolRepository $volRepository,EventsRepository $eventsRepository)
    {
        $panier=$session->get('panier',[]);
        $panierWithData=[];


        $q=0;
        $q1=0;
        $q2=0;
        $q3=0;
        $q4=0;
        $q5=0;
        $total=0;


        foreach ($panier as $id => $quantite){

            $hotel = $hotelRepository->find($id);
            $transport = $transportRepository->find($id);
            $vol = $volRepository->find($id);
            $offre = $offresRepository->find($id);
            $event = $eventsRepository->find($id);


            if($hotel)
            {
                $panierWithData []=['prod'=>$hotel,
                    'quantite'=>$quantite];
                //  dd($panierWithData);
            }
            else if($transport)
            {
                $panierWithData []=['prod'=>$transport,
                    'quantite'=>$quantite];
            }
            else if($vol)
            {
                $panierWithData []=['prod'=>$vol,
                    'quantite'=>$quantite];
            }else if($offre)
            {
                $panierWithData []=['prod'=>$offre,
                    'quantite'=>$quantite];
            }else if($event)
            {
                $panierWithData []=['prod'=>$event,
                    'quantite'=>$quantite];
            }

            if($hotel instanceof Hotel)
            {
                $total += $hotel->getPrix() * $quantite;
                $q1+= $quantite;
                $flashy->success('Added to Car Hotel 😍  ', '');
            }
            if($transport instanceof Transport)
            {
                $total +=$transport->getPrix() * $quantite;
                $q2+= $quantite;
                $flashy->success('Added to Car Transport 😍 ', '');

            }
            if($vol instanceof Vol)
            {
                $total += $vol->getPrix() * $quantite;
                $q3+= $quantite;
                $flashy->success('Added to Car vol 😍', '');
            }
            if($offre instanceof Offre)
            {
                $total +=  $offre->getPrix() * $quantite;
                $q4+= $quantite;
                $flashy->success('Added to Car offre 😍 ', '');

            }
            if($event instanceof Events)
            {
                $total += $event->getPrix() * $quantite;
                $q5+= $quantite;
                $flashy->success('Added to Car event 😍', '');
            }




        }
        $q = $q1+$q2+$q3+$q4+$q5;

       // dd($q1,$q2,$q3,$q4,$q5);

       // dd($panierWithData,$q);
        $session->set('panier',$panier);

        return $this->render('carte/index.html.twig',['items' => $panierWithData , 'total'=>$total,'quantite'=>$q,] );

    }


    /**
     * @Route("/carte/add/{id}",name="cart_adde")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function add(Request $request,$id,SessionInterface $session)
    {
        $panier=$session->get('panier',[]);



        if (!empty($panier[$id])) {
            $panier[$id]+=$request->get("quantity");
        }else{
            $panier[$id]=$request->get("quantity");
        }

        // dd($panier);

        $session->set('panier',$panier);

        return $this->redirectToRoute("cart_index");

    }


    /**
     * @Route("/Panier/remove{id}" ,name="cart_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id,SessionInterface $session){
        $panier=$session->get('panier',[]);
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);

        $this->addFlash('message','Le message a bien ete envoye');
        $this->addFlash(
            'info' ,' product deleted !');

        return $this->redirectToRoute("cart_index");

    }



}
