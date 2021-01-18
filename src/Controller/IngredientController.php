<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * @Route("/ingredient", name="ingredient")
     */
    public function index(): Response
    {
        return $this->render('ingredient/index.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }
    /**
     * @Route("/admin/ingredient/create", name="ingredient_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {

        $ingredient = new Ingredients;

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ingredient);
            $em->flush();



            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render('ingredient/create.html.twig', [
            'formview' => $formview,
        ]);
    }
}
