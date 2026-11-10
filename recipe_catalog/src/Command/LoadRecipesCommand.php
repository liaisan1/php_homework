<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-recipes',
    description: 'Добавление тестовых рецептов'
)]
class LoadRecipesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $user = new User();
        $user->setName('Анна');
        $user->setEmail('anna@example.com');
        $user->setPassword('test-data-no-login');

        $this->entityManager->persist($user);

        $categories = [
            'Супы' => [
                ['Борщ', 'Традиционный суп со свёклой.',
                    'Свёкла, капуста, картофель, морковь, лук',
                    'Нарезать овощи, добавить в бульон и варить до готовности'],
            ],
            'Салаты' => [
                ['Овощной салат', 'Простой салат из свежих овощей.',
                    'Помидоры, огурцы, зелень, масло',
                    'Нарезать овощи, добавить зелень и заправить маслом'],
            ],
            'Десерты' => [
                ['Сырники', 'Сырники из творога на сковороде',
                    'Творог, яйцо, мука, сахар',
                    'Смешать ингредиенты, сформировать сырники и обжарить'],
            ],
        ];

        foreach ($categories as $categoryName => $recipes) {
            $category = new Category();
            $category->setName($categoryName);

            $this->entityManager->persist($category);

            foreach ($recipes as $data) {
                $recipe = new Recipe();
                $recipe->setTitle($data[0]);
                $recipe->setDescription($data[1]);
                $recipe->setIngredients($data[2]);
                $recipe->setInstructions($data[3]);
                $recipe->setCategory($category);
                $recipe->setAuthor($user);

                $this->entityManager->persist($recipe);
            }
        }

        $this->entityManager->flush();

        $output->writeln('Тестовые рецепты добавлены');

        return Command::SUCCESS;
    }
}
