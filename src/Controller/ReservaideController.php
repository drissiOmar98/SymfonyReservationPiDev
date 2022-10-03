<?php

namespace App\Controller;


use App\Repository\ReservationPanierRepository;
use App\Service\QrCodeService;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/reservaide")
 */
class ReservaideController extends AbstractController
{
    /**
     * @Route("/{id}", name="reservaide_index")
     * @param ReservationPanierRepository $reservationPanierRepository
     * @param QrcodeService $service
     * @param $id
     * @return Response
     */
    public function index(ReservationPanierRepository $reservationPanierRepository,QrCodeService $service,$id): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
       // dd($service->qrcode('symfony'));
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $ss =  $service->qrcode2($id);

       // $reservation = $reservationPanierRepository->find($id);
        $reservation = $reservationPanierRepository->find($id);
       // dd($id,$reservation);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservaide/pdf.html.twig', [
            'reservation' => $reservation,'qrCode'=>$ss,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste mypdf.pdf", [
            "Attachment" => true
        ]);

    }
}
