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
     * @Route("/admin/recipes/show", name="recipe_showAll")
     */
    public function showAll(RecipesRepository $recipesRepository)
    {
        $recipes = $recipesRepository->findAll();

        return $this->render('recipes/show_all.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/admin/recipes/show/{id}", name="recipe_show", requirements={"id": "\d+"})
     */
    public function show($id, RecipesRepository $recipesRepository)
    {
        $recipe = $recipesRepository->find($id);

        return $this->render('recipes/show.html.twig', [
            'recipe' => $recipe
        ]);
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


            $this->addFlash(
                'success',
                'La recette de ' . $recipe->getName() . ' a bien été ajouté !'
            );

            return $this->redirectToRoute('recipe_showAll');
        }

        $formview = $form->createView();

        return $this->render('recipes/create.html.twig', [
            'formview' => $formview,
        ]);
    }

    /**
     * @Route("/admin/recipe/edit/{id}", name="recipe_edit", requirements={"id": "\d+"})
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

            return $this->redirectToRoute('recipe_show', [
                'id' => $id
            ]);
        }

        $formview = $form->createView();

        return $this->render('recipe/create.html.twig', [
            'formview' => $formview,
            'recipe' => $recipe,
        ]);
    }

    /**
     * @Route("/admin/recipe/delete/{id}", name="recipe_delete", requirements={"id": "\d+"})
     */
    public function delete($id, RecipesRepository $recipesRepository, EntityManagerInterface $em)
    {
        $recipe = $recipesRepository->find($id);

        $em->remove($recipe);
        $em->flush();

        $this->addFlash(
            'success',
            'La recette ' . $recipe->getName() . ' a bien été supprimée !'
        );

        return $this->redirectToRoute('recipe_showAll');
    }
}
