<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeController extends AbstractController
{
    /**
     * @Route("/", name="employe")
     */
    public function index()
    {
        $employes = $this->getDoctrine()->getRepository(Employe::class)->findAll();
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    /**
     * @Route("/delete/{employe}", name="delete_employe")
     */
    public function delete(Employe $employe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($employe);
        $em->flush();

        return $this->redirectToRoute('employe');

    }

    /**
     * @Route("/employe/add", name="add_employe")
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Employe();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $photoUser = $form->get('photo')->getData();

            if ($photoUser){
                $newFilename = uniqid().'.'.$photoUser->guessExtension();
                try {
                    $photoUser->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                    $user->setPhoto('images/' .$newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('employe');
        } else {
            return $this->render('employe/register.html.twig', [
                'form' => $form->createView(),
            ]);
        }


    }
}
