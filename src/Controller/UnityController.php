<?php

namespace App\Controller;

use App\Entity\Unity;
use App\Form\UnityType;
use App\Repository\UnityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnityController extends AbstractController
{
    /**
     * @Route("/admin/unity/show", name="unity_show")
     */
    public function showAll(UnityRepository $unityRepository)
    {
        $unities = $unityRepository->findAll();

        return $this->render('unity/show.html.twig', [
            'unities' => $unities,
        ]);
    }

    /**
     * @Route("/admin/unity/create", name="unity_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
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

    /**
     * @Route("admin/unity/{id}/edit", name="unity_edit")
     */
    public function edit($id, UnityRepository $unityRepository, Request $request, EntityManagerInterface $em)
    {
        $unity = $unityRepository->find($id);

        $form = $this->createForm(UnityType::class, $unity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('unity_show', [
                'unity' => $unity
            ]);
        }

        $formView = $form->createView();

        return $this->render('unity/edit.html.twig', [
            'formview' => $formView,
            'unity' => $unity,
        ]);
    }
}
