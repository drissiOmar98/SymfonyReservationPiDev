<?php

namespace App\Controller;


use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use App\Service\QrCodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\api\TwilioAPI;

/**
 * @Route("/transport")
 */
class TransportController extends AbstractController
{
    /**
     * @Route("/", name="transport_index", methods={"GET"})
     */
    public function index(TransportRepository $transportRepository,Request $request ,PaginatorInterface $paginator): Response
    {
        $tr = $transportRepository->findAll();
        $tr = $paginator->paginate(
            $tr,
            $request->query->getInt('page',1),
            3
        );
        return $this -> render('transport/afficherr.html.twig',
            ['transport' =>$tr,
            ]);
    }

    /**
     * @Route("/{id}", name="AffiTrans", methods={"GET"})
     * @param Transport $transport
     * @return Response
     */
    public function show(Transport $transport,QrCodeService $service):Response
    {
        $ss =  $service->qrcodeH($transport->getVers());
        return $this -> render('transport/afficherT.html.twig',['transport' =>$transport,'qrCode'=>$ss]);
    }


    /**
     * @param TransportRepository $repository
     * @param Request $request
     * @return Response
     * @Route("SarchTr/",name="rechT")
     */
    function SearchType(TransportRepository $repository,Request $request ,PaginatorInterface $paginator)
    {

        if($request->get("rech") == null)
        {

            $transport = $repository -> findAll();
        }else
        {
            $type =$request->get('rech');
            $in =$request->get('in');
            $out =$request->get('out');
            $transport = $repository->SearchType($type,$in,$out);
        }
        $transport = $paginator->paginate(
            $transport,
            $request->query->getInt('page',1),
            2
        );

        return $this -> render('transport/afficherr.html.twig',['transport' =>$transport]);

    }

    /**
     * @param TransportRepository $repository
     * @return Response
     * @Route("TQB/" ,name="trieTPrix")
     */
    function OrderByDateQB(TransportRepository $repository)
    {
        $transport = $repository->OrderByNomQB();
        return $this -> render('transport/afficherr.html.twig',['transport' =>$transport]);
    }

    /**
     * @param TransportRepository $repository
     * @return Response
     * @Route ("aff",name="aff")
     */
    public function Affiche(TransportRepository $repository)
    {
        // $repo=$this->getDoctrine()->getRepository(Transport::class);
        $transport = $repository->findAll();
        return $this->render("transport/transport.html.twig", ['transport' => $transport]);
    }

    /**
     * @param TransportRepository $repository
     * @return Response
     * @Route ("/affront",name="afffront")
     */
    public function affront(TransportRepository $repository)
    {
        // $repo=$this->getDoctrine()->getRepository(Transport::class);
        $transport = $repository->findAll();
        return $this->render("testfront.html.twig", ['transport' => $transport]);
    }

    /**
     * @Route ("Supp/{id}",name="d")
     */
    function Delete($id, TransportRepository $repository)
    {
        //recuperer l'objet a suprrimer
        $transport = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($transport);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("aff");
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("add",name="ajouttransport")
     */
    function add(Request $request)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($transport);
            $em->flush();

            $this ->addFlash(
                'info',
                'Transport ajouté !'
            );

            $twilio = new TwilioApi('AC7d9b9a8eec70ffbb4a504a3453a44488','00eefc7b4626a7c73f358efe8d926e44','+17249481678');
            $twilio->sendSMS('+21625524614','Moyen de Transport Créer avec success');

            return $this->redirectToRoute('aff');
        }
        return $this->render('transport/add.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("transport/update/{id}",name="update")
     * @param TransportRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    function update(TransportRepository $repository, $id, Request $request)
    {

        $transport = $repository->find($id);
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush(); $this ->addFlash(
                'info',
                'Transport modifié !'
            );


            return $this->redirectToRoute("aff");

        }

        return $this->render('transport/update.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @param TransportRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/recherche",name="recherche")
     */
    function Recherche(TransportRepository $repository, Request $request)
    {
        $data = $request->get('search');
        $transport = $repository->findBy(['id' => $data]);
        return $this->render("transport/transport.html.twig", ['transport' => $transport]);
    }


    /**
     * @param TransportRepository $repository
     * @return Response
     * @Route ("/transport/ListDQL",name="tri")
     */
    function OrderByPriceDQL(TransportRepository $repository)
    {
        $transport = $repository->OrderByPriceDQL();
        return $this->render("transport/transport.html.twig", ['transport' => $transport]);
    }
    /**
     * @param TransportRepository $repository
     * @return Response
     * @Route ("transport/asc",name="asc")
     */
    function OrderByPriceDQLASC(TransportRepository $repository)
    {
        $transport = $repository->OrderByPriceDQLASC();
        return $this->render("transport/transport.html.twig", ['transport' => $transport]);
    }


    /**
     * @Route("map/index", name="map_index", methods={"GET"})
     */
    public function map(): Response
    {
        return $this->render('map/index.html.twig');


    }

    /*
        function filterwords($text){
            $filterWords = array('fuck','pute','bitch','hello');
            $filterCount = sizeof($filterWords);
            for ($i = 0; $i < $filterCount; $i++) {
                $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
            }
            return $text;
        }
    */


    /**
     * @param TransportRepository $transportRepository
     * @return Response
     * @Route ("stat",name="stat")
     */
    public function stat(TransportRepository $transportRepository)
    {

        $nbs = $transportRepository->countEtat();
        $data = [['rate', 'TRANSPORT']];
        foreach( (array)$nbs as $nb)
        {
            $data[] = array($nb['e'], $nb['tran']);
        }
        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );

        $bar->getOptions()->setTitle('Etat des transports:');
        $bar->getOptions()->setHeight(500);
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->getTitleTextStyle()->setColor('#1E90FF');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);






        return $this->render('transport/stat.html.twig', array('barchart' => $bar,'nbs' => $nbs));
    }


}
