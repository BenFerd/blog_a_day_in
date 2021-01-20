<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientType;
use App\Repository\IngredientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * @Route("/admin/ingredient/showAll", name="ingredient_showAll")
     */
    public function showAll(IngredientsRepository $ingredientsRepository)
    {
        $ingredients = $ingredientsRepository->findAll();


        return $this->render('ingredient/show_all.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * @Route("/admin/ingredient/show/{id}", name="ingredient_showOne", requirements={"id": "\d+"})
     */
    public function showOne($id, IngredientsRepository $ingredientsRepository)
    {
        $ingredient = $ingredientsRepository->find($id);

        return $this->render('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
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

            $this->addFlash(
                'success',
                'L\'ingrédient ' . $ingredient->getName() . ' a bien été ajouté !'
            );

            return $this->redirectToRoute('ingredient_showAll');
        }

        $formview = $form->createView();

        return $this->render('ingredient/create.html.twig', [
            'formview' => $formview,
        ]);
    }

    /**
     * @Route("/admin/ingredient/{id}/edit", name="ingredient_edit", requirements={"id": "\d+"})
     */
    public function edit($id, IngredientsRepository $ingredientsRepository, Request $request, EntityManagerInterface $em)
    {

        $ingredient = $ingredientsRepository->find($id);

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('ingredient_showOne', [
                'id' => $id
            ]);
        }

        $formview = $form->createView();

        return $this->render('ingredient/edit.html.twig', [
            'formview' => $formview,
        ]);
    }

    /**
     * @Route("/admin/ingredient/delete/{id}", name="ingredient_delete", requirements={"id": "\d+"})
     */
    public function delete($id, IngredientsRepository $ingredientsRepository, EntityManagerInterface $em)
    {
        $ingredient = $ingredientsRepository->find($id);

        $em->remove($ingredient);
        $em->flush();

        $this->addFlash(
            'success',
            'L\'ingrédient ' . $ingredient->getName() . ' a bien été supprimé !'
        );

        return $this->redirectToRoute('ingredient_showAll');
    }
}
