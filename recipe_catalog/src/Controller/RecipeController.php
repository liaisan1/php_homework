<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Service\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/', name: 'recipe_index')]
    public function index(RecipeService $recipeService): Response
    {
        $recipes = $recipeService->getAll();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/new', name: 'recipe_new')]
    public function new(
        Request $request,
        RecipeService $recipeService
    ): Response {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeService->setDefaultAuthor($recipe);
            $recipeService->save($recipe);

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        '/recipe/{id}/edit',
        name: 'recipe_edit',
        requirements: ['id' => '\d+']
    )]
    public function edit(
        int $id,
        Request $request,
        RecipeService $recipeService
    ): Response {
        $recipe = $recipeService->getById($id);

        if ($recipe === null) {
            throw $this->createNotFoundException('Рецепт не найден');
        }

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeService->save($recipe);

            return $this->redirectToRoute('recipe_show', [
                'id' => $recipe->getId(),
            ]);
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
        ]);
    }

    #[Route(
        '/recipe/{id}/delete',
        name: 'recipe_delete',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function delete(
        int $id,
        Request $request,
        RecipeService $recipeService
    ): Response {
        $recipe = $recipeService->getById($id);

        if ($recipe === null) {
            throw $this->createNotFoundException('Рецепт не найден');
        }

        if (!$this->isCsrfTokenValid(
            'delete_recipe_' . $recipe->getId(),
            $request->request->getString('_token')
        )) {
            throw $this->createAccessDeniedException('Неверный токен');
        }

        $recipeService->delete($recipe);

        return $this->redirectToRoute('recipe_index');
    }

    #[Route(
        '/recipe/{id}',
        name: 'recipe_show',
        requirements: ['id' => '\d+']
    )]
    public function show(
        int $id,
        RecipeService $recipeService
    ): Response {
        $recipe = $recipeService->getById($id);

        if ($recipe === null) {
            throw $this->createNotFoundException('Рецепт не найден');
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
