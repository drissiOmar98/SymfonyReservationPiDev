<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Hotel;
use App\Entity\Offre;
use App\Entity\PostDislike;
use App\Entity\PostLike;
use App\Entity\ReservationPanier;
use App\Form\Comment2Type;
use App\Form\OffreType;
use App\Form\SearchType;
use App\Repository\OffreRepository;
use App\Repository\PostDislikeRepository;
use App\Repository\PostLikeRepository;
use App\Service\QrCodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * @Route("/offres")
 */
class OffresController extends AbstractController
{
    /**
     * @Route("/", name="offres_index", methods={"GET"})
     */
    public function index(Request $request ,PaginatorInterface $paginator): Response
    {
        $offres = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();
        $offres = $paginator->paginate(
            $offres,
            $request->query->getInt('page',1),
            3
        );

        return $this -> render('offre/afficherO.html.twig',
            ['offres' =>$offres
            ]);
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/AfficheOffre", name="AfficherOffre")
     */
    public function showback(Request $request , PaginatorInterface $paginator):Response
    {

        $offers = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();
        $offers = $paginator->paginate(
            $offers,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('offre/index.html.twig', [
            'offers' => $offers,
        ]);
    }


    /**
     * @Route("/Add/{id}",  name="add_offer",methods={"GET","POST"})
     */
    public function add(ReservationPanier $reservationPanier,Request $request ,FlashyNotifier $flashy) : Response
    {
        $offre = new Offre();
        // $offre->setIdRes($id);
        $form = $this -> createForm(OffreType::class,$offre);


        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $file=$offre->getPath();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }


            $flashy->message('offre created  ', 'http://your-awesome-link.com');
            $em = $this ->getDoctrine()->getManager();
            // dd($id);

            $offre->setIdRes($reservationPanier);
            $offre->setPath($fileName);
            // dd($offre);
            $em -> persist( $offre);
            $em -> flush();



            return $this -> redirectToRoute('AfficherOffre');
        }
        return $this -> render( 'offre/Add.html.twig',[
            'offre'=>$offre,
            'form' => $form -> createView()

        ]);

    }

    /**
     * @Route("{id}", name="AffiOffres", methods={"GET"})
     * @param Offre $offre
     * @return Response
     */
    public function show($id,Offre $offre,QrCodeService $service,PostLikeRepository $like,PostDislikeRepository $dislike):Response
    {
        $c1=0;
        $c3=0;
        $c4=0;

        $l = $like->CountLikeID($id);
        $l1 = $dislike->CountLikeID($id);

        foreach ($l as $key => $value )
        {
            foreach ($value as $k => $v)
            {
                $c1 = $value[$k];
            }
        }
        foreach ($l1 as $key => $value )
        {
            foreach ($value as $k => $v)
            {
                $c3 = $value[$k];
            }
        }

        $c4=$c1-$c3;


        if($c4>0 && $c4<3)
        {
            $c2=1;
        }elseif ($c4>=3 && $c4<5)
        {
            $c2=2;
        }elseif ($c4>=5 && $c4<7)
        {
            $c2=3;
        }elseif ($c4>=7 && $c4<10)
        {
            $c2=4;
        }elseif($c4>=10){
            $c2=5;
        }else
        {
            $c2=0;
        }
        $ss =  $service->qrcodeH($offre->getNom());
        return $this -> render('offre/afficherOff.html.twig',['offres' =>$offre,'qrCode'=>$ss,'rate'=>$c2,]);
    }

    /**
     * @Route("/SarchOffres",name="rechO")
     */
    function SearchNo(OffreRepository $repository,Request $request,PaginatorInterface $paginator)
    {

        if($request->get("rech") == null)
        {

            $offres = $repository -> findAll();
        }else
        {
            $nom =$request->get('rech');
            $in =$request->get('in');
            $out =$request->get('out');
            $offres = $repository->SearchNom($nom,$in,$out);
        }

        $offres = $paginator->paginate(
            $offres,
            $request->query->getInt('page',1),
            3
        );

        return $this -> render('offre/afficherO.html.twig',['offres' =>$offres

        ]);

    }

    /**
     * @return Response
     * @Route("/offres/ListOQB" ,name="trieTaux")
     */
    function OrderByPeriodQB(OffreRepository $repository)
    {
        $offres = $repository->OrderByTauxQB();
        return $this -> render('offre/afficherO.html.twig',['offres' =>$offres]);
    }










    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/del/{id}",name="delete")
     */
    function Delete($id,OffreRepository $offreRepository,FlashyNotifier $flashy):Response
    {
        $off=$offreRepository->find($id);
        //dd($off);
        $em=$this->getDoctrine()->getManager();
        $em->remove($off);
        $em->flush();

        $flashy->error(' Produit supprimée  :(', 'http://your-awesome-link.com');

        // redirection vers la meme vue
        return $this->redirectToRoute("AfficherOffre");
    }



    /**
     * @param OffreRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/{id}/edit",name="updateOffre",methods={"GET","POST"})
     */
    public function Update(OffreRepository $repository,$id,Request $request,FlashyNotifier $flashy):Response
    {

        $offre = $repository -> find($id);
        $form = $this -> createForm(OffreType::class,$offre);
        $form -> add('Modifier',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $flashy->warning('Produit modifié "Bien" ! ', 'http://your-awesome-link.com');
            $em = $this ->getDoctrine()->getManager();
            $em -> flush();
            return $this -> redirectToRoute('AfficherOffre');
        }
        return $this -> render( 'offre/Update.html.twig',[
            'form' => $form -> createView()
        ]);

    }








        /**
         * @Route("/offre/ListQB",name="trie")
         */
        function OrderByMailQB(OffreRepository $repository,Request $request , PaginatorInterface $paginator):Response
        {
            $offre = $repository->OrderByMailQBback();
            $offre = $paginator->paginate(
                $offre,
                $request->query->getInt('page',1),
                4
            );

            return $this->render('offre/index.html.twig',['offers' =>$offre]);
        }


    /**
     * @param $id
     * @param QrcodeService $qrcodeService
     * @return Response
     * @Route("/Qr/{id}",name="Qrpage")
     */

    public function QrCode($id, QrcodeService $qrcodeService,Request $request): Response
    {
        $qrCode = null;
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);
        }

        return $this->render('offre/afficherQr.html.twig', [
            'form' => $form->createView(),
            'qrCode' => $qrCode
        ]);
    }


    /**
     * @Route ("/{id}/like",name="post_like")
     * @param Offre $offre
     * @param PostLikeRepository $likeRepo
     * @return Response
     */
    public function like(Offre $offre,PostLikeRepository $likeRepo):

    Response
    {
        $like = $likeRepo->findOneBy([
            'post' => $offre,

        ]);

        $like = new PostLike();
        $like->setPost($offre);
        //  ->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json(['code' => 200,
            'message' => 'like bien ajouté',
            'likes' => $likeRepo->count(['post' => $offre])], 200);

    }

    /**
     * @Route ("/{id}/dislike",name="post_dislike")
     * @param Offre $offre
     * @param PostDislikeRepository $likeRepo
     * @return Response
     */
    public function Dislike(Offre $offre,PostDislikeRepository $likeRepo):

    Response
    {

        $dislike = $likeRepo->findOneBy([
            'post' => $offre,

        ]);

        $dislike = new PostDislike();
        $dislike->setPost($offre);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($dislike);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Dislike',
            'likes' => $likeRepo->count(['post' => $offre])
        ], 200);

    }

    /**
     * @Route("/stat", name="statpro")
     * @param PostLikeRepository $like
     * @param PostDislikeRepository $dislike
     * @return Response
     */
       public function stat(PostLikeRepository $like,PostDislikeRepository $dislike ) : Response
       {

          $repository = $this->getDoctrine()->getRepository(Offre::class);
           $offre = $repository->findAll();

         //  $pro = $this->getDoctrine()->getManager();

           $c1=0;
           $c2=0;

           $l = $like->CountLike();

           $l1 = $dislike->CountLike();

             foreach ($l as $key => $value )
             {
                 foreach ($value as $k => $v)
                 {
                     $c1 = $value[$k];
                 }
             }
           foreach ($l1 as $key => $value )
           {
               foreach ($value as $k => $v)
               {
                   $c2 = $value[$k];
               }
           }


            //
            //dd($c1,$c2);

           $pieChart = new PieChart();

           $pieChart->getData()->setArrayToDataTable(
               [['LIKE', 'Nombre'],
                   ['likes', $c1],
                   ['dislikes',$c2],
               ]
           );

           $pieChart->getOptions()->setTitle('Top Likes');
           $pieChart->getOptions()->setHeight(500);
           $pieChart->getOptions()->setWidth(900);
           $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
           $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
           $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
           $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
           $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

           return $this->render('offre/stat.html.twig', array('piechart' => $pieChart));

    }


    /**
     * @Route("/comment/{id}", name="commentaire",methods={"GET","POST"} )
     */
    public function commentaire(Request $request, OffreRepository $offresRepository,$id,FlashyNotifier $flashy) :Response
    {
        $post=$offresRepository->find($id);
        $comment=new Commentaire();

        $commentForm=$this->createForm(Comment2Type::class,$comment);
        // $commentForm -> add('Send',SubmitType::class);
        $commentForm->handleRequest($request);


        if($commentForm -> isSubmitted() && $commentForm -> isValid())
        {
            $comment->setCreatedAt(new DateTime());
            $comment->setpost($post);
            $comment->setActive(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $flashy->warning('comment well sent ! ', 'http://your-awesome-link.com');
            return $this->redirectToRoute('offres_index');

        }

        return $this->render('offre/Comment.html.twig', [
            'commentForm'=>$commentForm->createView()
        ]);

    }


    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ShowComment", name="ShowComment")
     */
    public function showComment(Request $request , PaginatorInterface $paginator):Response
    {

        $comment = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('offre/commentBack.html.twig', [
            'commentaire' => $comment,

        ]);
    }










}
