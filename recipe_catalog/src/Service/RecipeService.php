<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RecipeService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function getAll(): array
    {
        return $this->entityManager
            ->getRepository(Recipe::class)
            ->findAll();
    }

    public function getById(int $id): ?Recipe
    {
        return $this->entityManager
            ->getRepository(Recipe::class)
            ->find($id);
    }

    public function save(Recipe $recipe): void
    {
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();
    }

    public function delete(Recipe $recipe): void
    {
        $this->entityManager->remove($recipe);
        $this->entityManager->flush();
    }

    public function setDefaultAuthor(Recipe $recipe): void
    {
        $author = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'anna@example.com']);

        if ($author === null) {
            throw new \RuntimeException('Автор не найден');
        }

        $recipe->setAuthor($author);
    }
}
