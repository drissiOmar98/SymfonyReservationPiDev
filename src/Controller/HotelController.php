<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use App\Repository\ReservationRepository;
use App\Service\QrCodeService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/hotel")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="hotel_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {

        $hotels = $this->getDoctrine()
            ->getRepository(Hotel::class)
            ->findAll();
        $hotels = $paginator->paginate(
            $hotels,
            $request->query->getInt('page',1),
            4
        );

        return $this -> render('hotel/afficherS.html.twig',
            ['hotel' =>$hotels,
                ]);

    }

    /**
     * @Route("/ListByhotel/{id}")
     */
    function listReservationByHotel(ReservationRepository $repReservation,HotelRepository $repHotel,$id)
    {
        $hotel = $repHotel->find($id);
        $reservation = $repReservation->listReservationByHotel($hotel->getIdh());
        return $this->render("reservation/afficher.html.twig",['c'=>$hotel,'res'=>$reservation]);
    }


    /**
     * @Route("/{id}", name="AffiHotel", methods={"GET"})
     */
    public function show(Hotel $hotel,QrCodeService $service): Response
    {


        $ss =  $service->qrcodeH($hotel->getLieu());
        return $this -> render('hotel/afficherH.html.twig',['hotel' =>$hotel,'qrCode'=>$ss]);
    }

    /**
     * @Route("affi/", name="AffiHotelback", methods={"GET"})
     * @param Hotel $hotel
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function show2(Hotel $hotel,Request $request,PaginatorInterface $paginator): Response
    {
        $hotel = $paginator->paginate(
            $hotel,
            $request->query->getInt('page',1),
            2
        );
        return $this -> render('hotel/afficherS.html.twig',['hotel' =>$hotel]);
    }

    /**
     * @Route("Search",name="rechH")
     */
    function SearchLieu(HotelRepository $repository,Request $request ,PaginatorInterface $paginator)
    {

        if($request->get("rech") == null)
        {

            $hotel = $repository -> findAll();
        }else
        {
            $lieu =$request->get('rech');
            $in =$request->get('in');
            $out =$request->get('out');
            $hotel = $repository->SearchLieu($lieu,$in,$out);
        }

        $hotel = $paginator->paginate(
            $hotel,
            $request->query->getInt('page',1),
            2
        );

        return $this -> render('hotel/afficherS.html.twig',['hotel' =>$hotel]);

    }

    /**
     * @Route("/get/ListQB" ,name="trieEtoile")
     */
    function OrderByDateQB(Request $request ,HotelRepository $repository,PaginatorInterface $paginator)
    {
        $hotel = $repository->OrderByEtoileQB();
        $hotel = $paginator->paginate(
            $hotel,
            $request->query->getInt('page',1),
            6
        );
        return $this -> render('hotel/afficherS.html.twig',['hotel' =>$hotel]);
    }


    /**
     * @param HotelRepository $repository
     * @return Response
     * @Route ("afficherHotel",name="affHotel")
     */
    public function Affiche(HotelRepository $repository)
    {
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $hotel = $repository->findAll();
        return $this->render("hotel/affichage.html.twig", ['hotel' => $hotel]);
    }


    /**
     * @param HotelRepository $repository
     * @return Response
     * @Route ("affFront",name="affFront")
     */

    public function AfficheFront(HotelRepository $repository)
    {
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $hotel = $repository->findAll();
        return $this->render("hotelFront/afficherFront.html.twig", ['hotel' => $hotel]);
    }




    /**
     * @Route ("Supp_{id}",name="del")
     */
    function Delete($id, HotelRepository $repository)
    {
        $hotel = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('affHotel');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("Add",name="Add")
     */
    function Add(Request $request )
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('affHotel');
        }
return $this->render('hotel/add.html.twig', [
    'form' => $form->createView()
]);

}

/**
 * @Route ("hotelUpdate_{id}",name="mise")
 */
function Update(HotelRepository $repository, $id, Request $request)
{
    $hotel = $repository->find($id);
    $form = $this->createForm(HotelType::class, $hotel);
    $form->add('Update', SubmitType::class);
    $form->handleRequest($request);


    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("affHotel");
    }
    return $this->render('hotel/update.html.twig', [
        'form' => $form->createView()
    ]);
}

/**
 * @param HotelRepository $repository
 * @Route ("hotelRecherche",name="recherche")
 */
function Recherche(HotelRepository $repository, Request $request)
{
    $data = $request->get('search');

    $hotel = $repository->findBy(['lieu' => $data]);
    return $this->render("hotel/affichage.html.twig", ['hotel' => $hotel]);


}


/**
 * @Route("imp", name="impr")
 */
public function imprimeproduit(HotelRepository $repository): Response

{
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);

    $hotel = $repository->findAll();

    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('hotel/pdf.html.twig', [
        'hotel' => $hotel,
    ]);

    // Load HTML to Dompdf
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser (inline view)
    $dompdf->stream("Liste  Hotel.pdf", [
        "Attachment" => true
    ]);

}


}
