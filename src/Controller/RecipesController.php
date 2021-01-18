<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipeType;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipesController extends AbstractController
{
    /**
     * @Route("/recipes", name="recipes")
     */
    public function show()
    {




        return $this->render('recipes/show.html.twig');
    }

    /**
     * @Route("/admin/recipe/create", name="recipe_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {

        $recipe = new Recipes;

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();



            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render('recipes/create.html.twig', [
            'formview' => $formview,
        ]);
    }

    /**
     * @Route("/admin/recipe/edit/{id}", name="recipe_edit")
     */
    public function edit($id, RecipesRepository $recipesRepository, Request $request, EntityManagerInterface $em)
    {

        $recipe = $recipesRepository->find($id);

        if (!$recipe) {
            throw new NotFoundHttpException("Cette recette n'existe pas!");
        }

        $form = $this->createForm(recipeFormType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render('recipe/create.html.twig', [
            'formview' => $formview,
            'recipe' => $recipe,
        ]);
    }
}
