<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\EventsType;
use App\Repository\CategorieRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @param CategorieRepository $repository
     * @return Response
     * @Route ("/afficheC",name="affichecat")
     */
    public function affiche(CategorieRepository  $repository){
        //$repo=$this->getDoctrine().getRepositoy(Events::class);
        $categories=$repository->findAll();
        return $this->render("categorie/affichageBack1.html.twig",['categorie'=>$categories]);
    }
    /**
     * @param CategorieRepository $repository
     * @return Response
     * @Route ("/afficheCAT",name="affichecategorie")
     */
    public function afficheC(CategorieRepository  $repository){
        //$repo=$this->getDoctrine().getRepositoy(Events::class);
        $categories=$repository->findAll();
        return $this->render("categorie/afficheFront.html.twig",['categorie'=>$categories]);
    }

    /**
     * @param $id
     * @param CategorieRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/del/{id}",name="b")
     */


    function Delete($id,CategorieRepository  $repository){
        //recuperer l'objet a suprrimer
        $categories=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($categories);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("affichecat");
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/add",name="addcat")
     */
    public function add(Request $request)
    {
        //faire une instance de notre entity
        $categories = new Categorie();
        //appeler notre formulaire
        $form = $this -> createForm(CategorieType::class,$categories);
        //ajouter button add
        $form -> add('Ajouter',SubmitType::class);
        //parcourir la requete
        $form -> handleRequest($request);
        //verifier si le formulaire s'il est bien soumis et les champs sont valides

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> persist( $categories);
            $em -> flush();
            //redirection ce cet condition uniquement
            return $this -> redirectToRoute('affichecat');
        }
        return $this -> render( 'categorie/add.html.twig',[
            'form' => $form -> createView()
        ]);

    }
    /**
     * @Route ("categorie/{id}",name="updatecat")
     */

    public function Update(CategorieRepository  $repository,$id,Request $request){
        $categories = $repository -> find($id);
        $form = $this -> createForm(CategorieType::class,$categories);
        $form -> add('Modifier',SubmitType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine()->getManager();
            $em -> flush();
            return $this -> redirectToRoute('affichecat');
        }
        return $this -> render( 'categorie/update.html.twig',[
            'updateC' => $form -> createView()
        ]);

    }
    /**
     * @param CategorieRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/searchcat",name="rechercheCategorie")
     */
    function Recherche(CategorieRepository $repository,Request $request){
        //pour recuperer ce qui a ete saisie dans input
        $data=$request->get('search');
        var_dump($data);
        $categories=$repository->findBy(['type'=>$data]);
        //copier coller de la vue de l'affichage
        return $this->render("categorie/afficheBack1.html.twig",['categorie'=>$categories]);

    }
    /**
     * @param CategorieRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/rechCat",name="rechCat")
     */
    function RechercheC(CategorieRepository $repository,Request $request){
        //pour recuperer ce qui a ete saisie dans input
        $data=$request->get('search');
        var_dump($data);
        $categories=$repository->findBy(['type'=>$data]);
        //copier coller de la vue de l'affichage
        return $this->render("categorie/afficheFront.html.twig",['categorie'=>$categories]);

    }

    /**
     * @param CategorieRepository $repository
     * @return Response
     * @Route ("/ListDQL")
     */
    function OrderByTypeDQL(CategorieRepository $repository){
        $categories=$repository->OrderByTypeDQL();
        return $this->render("categorie/afficheBack1.html.twig",['categorie'=>$categories]);
    }








    /**
     * @param CategorieRepository $repCategorie
     * @param EventsRepository $repEvents
     * @param $type
     * @return Response
     * @Route ("/categorie/ListByCategorie/{Type}")
     */
    function ListEventByCategorie(CategorieRepository $repCategorie,EventsRepository $repEvents,$type){
        $categories=$repCategorie->find($type);
        $events=$repEvents->listEventByCategorie($categories->getType());
        return $this->render("categorie/show.html.twig",['c'=>$categories,'events'=>$events]);

    }





}
