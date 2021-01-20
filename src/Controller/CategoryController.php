<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/showAll", name="category_showAll")
     */
    public function showAll(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/show_all.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/category/show/{id}", name="category_showOne", requirements={"id": "\d+"})
     */
    public function showOne($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {

        $category = new Category;

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();


            $this->addFlash(
                'success',
                'La catégorie ' . $category->getName() . ' a bien été ajouté !'
            );

            return $this->redirectToRoute('category_showAll');
        }

        $formview = $form->createView();

        return $this->render('category/create.html.twig', [
            'formview' => $formview,
        ]);
    }

    /**
     * @Route("/admin/category/edit/{id}", name="category_edit", requirements={"id": "\d+"})
     */
    public function edit($id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em)
    {

        $category = $categoryRepository->find($id);

        if (!$category) {
            throw new NotFoundHttpException("Cette catégorie n'existe pas!");
        }

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('category_showAll');
        }

        $formview = $form->createView();

        return $this->render('category/create.html.twig', [
            'formview' => $formview,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="category_delete", requirements={"id": "\d+"})
     */
    public function delete($id, CategoryRepository $categoryRepository, EntityManagerInterface $em)
    {
        $category = $categoryRepository->find($id);

        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'success',
            'La catégorie ' . $category->getName() . ' a bien été supprimée !'
        );

        return $this->redirectToRoute('category_showAll');
    }
}
