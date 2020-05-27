<?php

namespace App\Controller;

use App\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    /**
     * @Route("/", name="employe")
     */
    public function index()
    {
        $employes = $this->getDoctrine()->getRepository(Employe::class)->findAll();
        return $this->render('employe/index.html.twig', [
            'employes' => '$employes',
        ]);
    }

    /**
     * @Route("/delete/{employe", name="delete_employe")
     */
    public function delete(Employe $employe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($employe);
        $em->flush();

        return $this->redirectToRoute('employe');

    }
}
