<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\BackuserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * @Route("/frontuser")
 */
class UserfrontController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    /**
     * @Route("/", name="user_indexf", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('userfront/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_newf", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // mail
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('contact@elyes.com', '"elyes contact"'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            //end mail
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('userfront/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('userfront/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('userfront/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('dachboard');
    }
    /**
     * @Route("_newb", name="user_newb", methods={"GET","POST"})
     */
    public function newb(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user1 = new User();
        $formb = $this->createForm(BackuserType::class, $user1);
        $formb->handleRequest($request);

        if ($formb->isSubmitted() && $formb->isValid()) {
            $user1->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user1,
                    $formb->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user1);
            $entityManager->flush();
            // mail
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user1,
                (new TemplatedEmail())
                    ->from(new Address('contact@elyes.com', '"elyes contact"'))
                    ->to($user1->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            //end mail
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newb.html.twig', [
            'user1' => $user1,
            'formb' => $formb->createView(),
        ]);
    }


    /**
     * @param UserRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("rechercheuser",name="rechercheUser")
     */
    function SearchUser(UserRepository $repository,Request $request){
        $data=$request->get('search');
        $users=$repository->findBy(['id'=>$data]);
        return $this->render("userfront/index.html.twig",['users'=>$users]);
    }


}
