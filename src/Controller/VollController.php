<?php

namespace App\Controller;


use App\Entity\Hotel;
use App\Entity\Vol;
use App\Form\GvolType;
use App\Repository\VolRepository;
use App\Service\QrCodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Mail\Mails;

/**
 * @Route("/gvol")
 */
class VollController extends AbstractController
{
    /**
     * @Route("/", name="voll_index")
     * @param VolRepository $volRepository
     * @return Response
     */
    public function index(Request $request ,PaginatorInterface $paginator): Response
    {
        $vol = $this->getDoctrine()
            ->getRepository(Hotel::class)
            ->findAll();
        $vol = $paginator->paginate(
            $vol,
            $request->query->getInt('page',1),
            3
        );
        return $this -> render('gvol/affichervoll.html.twig',
            ['voll' =>$vol,
            ]);
    }

    /**
     * @Route("/{id}", name="AffiVoll", methods={"GET"})
     * @param Vol $voll
     * @return Response
     */
    public function show(Vol $voll,QrCodeService $service):Response
    {
        $ss =  $service->qrcodeH($voll->getVers());
        return $this -> render('gvol/afficherv.html.twig',['voll' =>$voll,'qrCode'=>$ss]);
    }

    /**
     * @Route("/get/Sar",name="rechVol", methods={"GET"})
     */

    function SearchNom(VolRepository $repository,Request $request ,PaginatorInterface $paginator): Response
    {

        if($request->get('rech') == null)
        {

            $voll = $repository -> findAll();
        }else
        {
            $nom =$request->get('rech');
            $in =$request->get('in');
            $out =$request->get('out');
            $voll = $repository->SearchVers($nom,$in,$out);
        }
        $voll = $paginator->paginate(
            $voll,
            $request->query->getInt('page',1),
            3
        );

        return $this -> render('gvol/affichervoll.html.twig',['voll' =>$voll]);

    }

    /**
     * @Route("/get/List" ,name="trieVPrix", methods={"GET"})
     * @param VolRepository $repository
     * @return Response
     */
    function OrderByPrixQB(VolRepository $repository): Response
    {
        $voll = $repository->OrderByPrixQB();
        return $this -> render('gvol/affichervoll.html.twig',['voll' =>$voll]);
    }


    /**
     * @param VolRepository $repository
     * @return Response
     * @Route ("affi",name="affi")
     */
    public function Affichev(VolRepository $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $vol=$repository->findAll();
        return $this->render("gvol/afficher.html.twig",['vol'=>$vol]);
    }

    /**
     * @Route ("/Supp1/{id}",name="d1")
     */
    function Deletev($id,VolRepository $repository){
        //recuperer l'objet a suprrimer
        $vol=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($vol);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("affi");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("addv",name="ajoutvol")
     */
    function addvol (Request $request,MailerInterface $mailer)
    {
        $gvol=new Vol();
        $form=$this->createForm(GvolType::class,$gvol);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($gvol);
            $em->flush();

            $this ->addFlash(
                'info',
                'Vol ajouté !'
            );
            $email = new Mails();
            $email->sendEmail( $mailer,'tunisport32@gmail.com','nourhene.maaouia@esprit.tn','testing email','Moyen de Transport Créer avec success');

        }
        return $this->render('gvol/addv.html.twig',[
            'f'=>$form->createView()
        ]);

    }

    /**
     * @Route("gvol/updatevol/{id}",name="updatev")
     */

    function updatevol (VolRepository $repository, $id, Request $request){

        $vol =$repository->find($id);
        $form=$this->createForm(GvolType::class,$vol);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this ->addFlash(
                'info',
                'Vol modifié !'
            );
            return$this->redirectToRoute("affi");

        }

        return $this->render('gvol/updatev.html.twig',[
            'f1'=>$form->createView()
        ]);

    }

    /**
     * @param VolRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/recherchev",name="recherchev")
     */
    function Recherchev (VolRepository $repository,Request $request){
        $data=$request->get('search');
        $vol=$repository->findBy(['numv'=>$data]);
        return $this->render("gvol/afficherv.html.twig",['vol'=>$vol]);
    }


    /**
     * @Route("/gvol/pdf", name="imprimer_index")
     */


    public function imprimevol(VolRepository $volRepository): Response

    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $vol = $volRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('gvol/pdf.html.twig', [
            'vol' => $vol,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste  vol.pdf", [
            "Attachment" => true
        ]);
    }


    // stat

    /**
     * @Route("/statistiquesvol",name="statistiques")
     * @param VolRepository $repository
     * @return Response
     */

    public function statistiques(VolRepository $repository)
    {

        $nbs = $repository->getART();
        $data = [['rate', 'VOL']];
        foreach($nbs as $nb)
        {
            $data[] = array($nb['volt'], $nb['cvol']);
        }
        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );

        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(50);
        return $this->render('gvol/statvol.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }


}
