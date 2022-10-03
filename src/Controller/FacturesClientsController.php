<?php

namespace App\Controller;

use App\Mail\Mails;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\FacturesClients;
use App\Form\FactureCType;
use App\Repository\FacturesClientsRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use App\api\TwilioAPI;



class FacturesClientsController extends AbstractController
{
    /**
     * @Route("/factures/clients", name="factures_clients")
     */
    public function index(): Response
    {
        return $this->render('factures_clients/indexF.html.twig', [
            'controller_name' => 'FacturesClientsController',
        ]);
    }

    /**
     * @param FacturesClientsRepository $repository
     * @return Response
     * @Route ("FactureAff",name="affF")
     */
    public function Affiche(FacturesClientsRepository $repository){
        $facture=$repository->findAll();
        return $this->render("factures_clients/afficherF.html.twig",['facture'=>$facture]);
    }

    /**
     * @Route ("FactureSupp/{id}",name="dF")
     * @param $id
     * @param FacturesClientsRepository $repository
     * @return Response
     */
    function Delete($id,FacturesClientsRepository $repository){
        //recuperer l'objet a suprrimer
        $books=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($books);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("affF");
    }

    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @Route("/FactureAdd", name="ajoutF")
     */
    function ADD(Request $request ,MailerInterface $mailer ){
        $facture=new FacturesClients();
        $form=$this->createForm(FactureCType::class,$facture);
        $form->add('Ajouter',SubmitType::class);
        $form -> handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            $twilio = new TwilioApi('AC927e0ea027f0ae20a54216fbb39b69ff','c90fbee3c06a343e598ea617f86030a6','+12184808910');
            $twilio->sendSMS('+21650486434','Facture Créer avec success');
            $email = new Mails();
            $email->sendEmail( $mailer,'tunisport32@gmail.com','jbara.aymen@esprit.tn','testing email','Facture Créer avec success');
                return $this->redirectToRoute('affF');

        }

        return $this->render('factures_clients/AddF.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("FactureUpdate/{id}",name="updateF")
     * @param FacturesClientsRepository $repository
     * @param $id
     * @param Request $request
     * @return Response
     */
    function Update(FacturesClientsRepository $repository,$id,Request $request){
        $facture=$repository->find($id);
        $form=$this->createForm(FactureCType::class,$facture);
        $form->add('Update',SubmitType::class );
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affF');
        }
        return $this->render('factures_clients/UpdateF.html.twig',[
            'form'=>$form->createView()

        ]);
    }

    /**
     * @param FacturesClientsRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("FactureRech",name="rechercheF")
     */
    function Recherche(FacturesClientsRepository $repository,Request $request){
        $data=$request->get('search');
        $facture=$repository->findBy(['idFac'=>$data]);

        return $this->render("factures_clients/afficherF.html.twig",['facture'=>$facture]);
    }
    /**
     * @param FacturesClientsRepository $repository
     * @return Response
     * @Route ("FactureListTri",name="triF")
     */
    function OrderByPriceDQL(FacturesClientsRepository  $repository){
        $facture=$repository->OrderByPriceDQL();
        return $this->render("factures_clients/afficherF.html.twig",['facture'=>$facture]);
    }

    /**
     * @param FacturesClientsRepository $repository
     * @return Response
     * @Route ("FactureListASC",name="triFASC")
     */
    function OrderByPriceDQL2(FacturesClientsRepository  $repository){
        $facture=$repository->OrderByPriceDQL2();
        return $this->render("factures_clients/afficherF.html.twig",['facture'=>$facture]);
    }

    /**
     * @Route("/statistiques",name="statistiquesFact")
     * @param FacturesClientsRepository $repository
     * @return Response
     */

    public function statistiques(FacturesClientsRepository $repository)
    {

        $nbs = $repository->getART();
        $data = [['rate', 'Facture']];
        foreach($nbs as $nb)
        {
            $data[] = array($nb['prixfact'], $nb['fact']);
        }
        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );

        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(50);
        return $this->render('factures_clients/statistique.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }

    /**
     * @Route("/imprimefacture", name="list")
     * @param FacturesClientsRepository $facture
     * @return Response
     */
    public function imprimefacture(FacturesClientsRepository $facture): Response

    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $facture = $facture->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('factures_clients/facturesPDF.html.twig', [
            'facture' => $facture,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste  Facture.pdf", [
            "Attachment" => true
        ]);
    }
    /*
    /**
     * @Route("/list", name="list", methods={"GET"})
     *//*
    public function listp(FacturesClients $Facture ) :Response

    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('isphpEnabled', 'true');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);




        // Retrieve the HTML generated in our twig file
        $html = $this ->renderView('factures_clients/afficherF.html.twig', [
            'Facture' => $Facture,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);


        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();


        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }*/

    /*
        /**
         * @Route("/statpro", name="statpro")
         *//*
    public function stat(){

        $repository = $this->getDoctrine()->getRepository(FacturesClients::class);
        $produit = $repository->findAll();

        $pro = $this->getDoctrine()->getManager();

        $c1=0;
        $c2=2;
        $c3=1;


        foreach ($produit as $produit)
        {
            if (  $produit->getIdFac()=="Protéine")  :

                $c1+=1;
            elseif ($produit->getIdFac()=="Vêtement"):

                $c2+=1;
            else :
                $c3 +=1;

            endif;

        }
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Nombre'],
                ['Materiel',  $c1],
                ['Vêtement',  $c2],
                ['Protéine',  $c3],

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

        return $this->render('factures_clients/stat.html.twig', array('piechart' => $pieChart));
    }
*/
}

