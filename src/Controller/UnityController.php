<?php

namespace App\Controller;

use App\Entity\Unity;
use App\Form\UnityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnityController extends AbstractController
{
    /**
     * @Route("/admin/unity/create", name="unity_create")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {

        $unity = new Unity;

        $form = $this->createForm(UnityType::class, $unity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($unity);
            $em->flush();



            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render('unity/create.html.twig', [
            'formview' => $formview,
        ]);
    }
}
