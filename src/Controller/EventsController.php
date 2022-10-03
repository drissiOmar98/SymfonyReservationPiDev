<?php

namespace App\Controller;

use App\Entity\Events;

use App\Entity\PostL;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use App\Repository\PostLRepository;
use App\Service\QrCodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Test\Constraint\RequestAttributeValueSame;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("/", name="events_index",methods={"GET"})
     */
    public function index(Request $request ,PaginatorInterface $paginator,EventsRepository $eventsRepository): Response
    {
        $events = $eventsRepository->findAll();
        $events = $paginator->paginate(
            $events,
            $request->query->getInt('page',1),
            3
        );
        return $this -> render('events/afficherE.html.twig',
            ['events' =>$events
            ]);
    }

    /**
     * @Route("/{id}", name="AffiEvents", methods={"GET"})
     * @param Events $events
     * @return Response
     */
    public function show(Events $events,QrCodeService $service): Response
    {
        $ss =  $service->qrcodeH($events->getLocation());
        return $this -> render('events/afficherE2.html.twig',['events' =>$events,'qrCode'=>$ss]);
    }




    /**
     * @Route("Se",name="rechE")
     */
    function SearchLieu(EventsRepository $repository,Request $request)
    {

        if($request->get("rech") == null)
        {

            $events = $repository -> findAll();
        }else
        {
            $lieu =$request->get('rech');
            $in =$request->get('in');
            $out =$request->get('out');
            $events = $repository->SearchLieu($lieu,$in,$out);
        }

        return $this -> render('events/afficherE.html.twig',['events' =>$events]);

    }

    /**
     * @param EventsRepository $repository
     * @return Response
     * @Route("/events/ListEQB" ,name="trieperiod")
     */
    function OrderByPeriodQB(EventsRepository $repository)
    {
        $events = $repository->OrderByPeriodQB();
        return $this -> render('events/afficherE.html.twig',['events' =>$events]);
    }


    /**
     * @Route ("/{id}/like",name="post_l")
     * @param Events $events
     * @param PostLRepository $likeRepo
     * @return Response
     */
    public function like(Events $events,PostLRepository $likeRepo):

    Response
    {
        $like = $likeRepo->findOneBy([
            'post' => $events,

        ]);

        $like = new PostL();
        $like->setPost($events);
        //  ->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json(['code' => 200,
            'message' => 'like bien ajouté',
            'likes' => $likeRepo->count(['post' => $events])], 200);




    }
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/omar/back", name="AfficherEvent")
     */
    public function showback(Request $request , PaginatorInterface $paginator):Response
    {

        $events = $this->getDoctrine()
            ->getRepository(Events::class)
            ->findAll();
        $events = $paginator->paginate(
            $events,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('events/affichage.html.twig', [
            'events' => $events,

        ]);
    }
    /**
     * @param $id
     * @param EventsRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("del/{id}",name="deleteevent")
     */

    function Delete($id,EventsRepository $repository,FlashyNotifier $flashy){
        //recuperer l'objet a suprrimer
        $events=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($events);
        $em->flush();
        $flashy->success('Event deleted!', 'http://your-awesome-link.com');
        //redirection vers la meme vue
        return $this->redirectToRoute("AfficherEvent");
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("event/add",name="addEvent")
     */
    public function add(Request $request,FlashyNotifier $flashy)
    {
        //faire une instance de notre entity
        $events = new Events();
        //appeler notre formulaire
        $form = $this -> createForm(EventsType::class,$events);
        //ajouter button add
        $form -> add('Ajouter',SubmitType::class);
        //parcourir la requete
        $form -> handleRequest($request);
        //verifier si le formulaire s'il est bien soumis et les champs sont valides

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> persist( $events);
            //envoyer ce qui a ete persisté
            $em -> flush();
            //redirection ce cet condition uniquement
            $flashy->success('Event added!', 'http://your-awesome-link.com');
            return $this -> redirectToRoute('AfficherEvent');
        }
        return $this -> render( 'events/add.html.twig',[
            'form' => $form -> createView()
        ]);

    }
    /**
     * @Route ("UP/{id}",name="updateevent")
     */

    public function Update(EventsRepository $repository,$id,Request $request,FlashyNotifier $flashy){
        $events = $repository -> find($id);
        $form = $this -> createForm(EventsType::class,$events);
        $form -> add('Modifier',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> flush();
            $flashy->success('Event updated!', 'http://your-awesome-link.com');
            return $this -> redirectToRoute('AfficherEvent');
        }

        return $this -> render( 'events/Update.html.twig',[
            'updateF' => $form -> createView()
        ]);

    }
    /**
     * @param EventsRepository $repository
     * @return Response
     * @Route ("ListDQL/event",name="List")
     */
    function OrderByPriceDQL(EventsRepository $repository){
        $events=$repository->OrderByPriceDQL();
        return $this->render("events/affitri.html.twig",['events'=>$events]);
    }
    /**
     * @param EventsRepository $repository
     * @return Response
     * @Route ("QB/event",name="QB")
     */
    function OrderByPriceQB(EventsRepository $repository){
        $events=$repository->OrderByPriceQB();
        return $this->render("events/affitri.html.twig",['events'=>$events]);
    }
    /**
     * @Route("/impr/imprime", name="impr")
     */
    public function imprimeevent(EventsRepository $repository)

    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $events = $repository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('events/pdf.html.twig', [
            'events' => $events,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste  Events.pdf", [
            "Attachment" => true
        ]);
    }
    /**
     * @Route("/art/statomar",name="statistiquesE")
     * @param EventsRepository $repository
     * @return Response
     */

    public function statistiques(EventsRepository $repository): Response
    {

        $nbs = $repository->getART();
        $data = [['rate', 'events']];
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
        return $this->render('events/stat.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }

















}
