<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Maison;
use App\Form\HotelType;
use App\Form\MaisonType;
use App\Repository\HotelRepository;
use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;


class MaisonController extends AbstractController
{
    /**
     * @Route("/maison", name="maison")
     */
    public function index(): Response
    {
        return $this->render('maison/index.html.twig', [
            'controller_name' => 'MaisonController',
        ]);
    }

    /**
     * @param MaisonRepository $repository
     * @return Response
     *@Route ("/afficher",name="afficher")

     */
    public function Affiche(MaisonRepository  $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $maison=$repository->findAll();
        return $this->render("maison/show.html.twig",['maison'=>$maison]);
    }


    /**
     * @param MaisonRepository $repository
     * @return Response
     *@Route ("/afficherFront",name="affichermaisonFront")

     */
    public function AfficheMaisonFront(MaisonRepository  $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $maison=$repository->findAll();
        return $this->render("hotelFront/afficherMaisonFront.html.twig",['maison'=>$maison]);
    }

    /**
     * @Route ("/suppu{id}",name="supp")
     */
    function Delete($id,MaisonRepository $repository){
        $maison=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($maison);
        $em->flush();
        return $this->redirectToRoute('afficher');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/ajouter",name="ajouter")
     */
    function  Add(Request $request){
        $maison = new Maison();
        $form=$this->createForm(MaisonType::class,$maison);
        $form->add('ajouter',SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($maison);
            $em->flush();
            return $this->redirectToRoute('afficher');
        }
        return $this->render('maison/add.html.twig',[
            'form'=>$form->createView()
        ]);

    }
    /**
     * @Route ("/maison_Update_{id}",name="updateMais")
     */
    function Update(MaisonRepository $repository,$id,Request $request){
        $maison=$repository->find($id);
        $form=$this ->createForm(MaisonType::class,$maison);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);



        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("afficher");
        }
        return $this->render('maison/modifier.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param MaisonRepository $repository
     * @Route ("maisonRecherche",name="search")
     */
    function Recherche(MaisonRepository $repository,Request $request){
        $data=$request->get('search');
        $maison=$repository->findBy(['nom'=>$data]);
        return $this->render("maison/show.html.twig",['maison'=>$maison]);
    }

    /**
     * @param MaisonRepository $repository
     * @Route ("maisonRechercheFront",name="searchMaisonFront")
     */
    function RechercheMaison(MaisonRepository $repository,Request $request){
        $data=$request->get('searchMaison');
        $maison=$repository->findBy(['nom'=>$data]);
        return $this->render("hotelFront/afficherMaisonFront.html.twig",['maison'=>$maison]);
    }


    /**
     * @param MaisonRepository $repository
     * @return Response
     * @Route ("/maisonListDQL",name="tri")
     */
    function OrderByPriceDQL(MaisonRepository  $repository){
    $maison=$repository->OrderByPriceDQL();
        return $this->render("maison/show.html.twig",['maison'=>$maison]);
    }

    /**
     * @param MaisonRepository $repository
     * @return Response
     * @Route ("/maisonList",name="trie")
     */
    function OrderByPrice(MaisonRepository  $repository){
        $maison=$repository->OrderByPrice();
        return $this->render("maison/show.html.twig",['maison'=>$maison]);
    }



    /**
     * @Route("/statistiquesMais",name="statistiquesMais")
     * @param maisonRepository $repository
     * @return Response
     */

    public function statistiques(maisonRepository $repository): Response
    {

        $nbs = $repository->getART();
        $data = [['rate', 'maison']];
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
        return $this->render('maison/stat.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }

}
