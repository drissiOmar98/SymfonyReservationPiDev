<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BooksController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function index(): Response
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }

    /**
     * @param BooksRepository $repository
     * @return Response
     * @Route ("EquipementAff",name="affE")
     */
    public function Affiche(BooksRepository $repository){
        // $repo=$this->getDoctrine()->getRepository(Hotel::class);
        $books=$repository->findAll();
        return $this->render("books/afficher.html.twig",['books'=>$books]);
    }
    /**
     * @Route ("EquipementSupp/{id}",name="d")
     */
    function Delete($id,BooksRepository $repository){
        //recuperer l'objet a suprrimer
        $books=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($books);
        $em->flush();
        //redirection vers la meme vue
        return $this->redirectToRoute("affE");
    }

    /**
     * @param Request $request

     * @return Response
     * @Route("EquipementAdd", name="ajout")
     */
    function ADD(Request $request ){
        $books=new Books();
    $form=$this->createForm(BooksType::class,$books);
    $form->add('Ajouter',SubmitType::class);
    $form -> handleRequest($request);
    if($form->isSubmitted()&& $form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $em->persist($books);
        $em->flush();
        return $this->redirectToRoute('affE');
    }
    return $this->render('books/Add.html.twig',[
        'form'=>$form->createView()
    ]);
    }
    /**
     * @Route("EquipementUpdate/{id}",name="updateE")
     */
    function Update(BooksRepository $repository,$id,Request $request){
        $books=$repository->find($id);
        $form=$this->createForm(BooksType::class,$books);
        $form->add('Update',SubmitType::class );
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affE');
        }
        return $this->render('books/Update.html.twig',[
            'form'=>$form->createView()

        ]);
    }

    /**
     * @param BooksRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("EquipementRech",name="recherche")
     */
    function Recherche(BooksRepository $repository,Request $request){
        $data=$request->get('search');
        $books=$repository->findBy(['id'=>$data]);

        return $this->render("books/afficher.html.twig",['books'=>$books]);
    }

    /**
     * @param BooksRepository $repository
     * @return Response
     * @Route ("EquipementListTri",name="triEqui")
     */
    function OrderByPriceDQL(BooksRepository  $repository){
        $books=$repository->OrderByPriceDQL();
        return $this->render("Books/afficher.html.twig",['books'=>$books]);
    }
}










