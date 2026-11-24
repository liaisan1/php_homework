<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:change-language',
    description: 'Изменение языка сайта'
)]
class ChangeLanguageCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument(
            'language',
            InputArgument::REQUIRED,
            'Язык сайта (ru или en)'
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int
    {
        $language = $input->getArgument('language');

        if (!in_array($language, ['ru', 'en'], true)) {
            $output->writeln('Доступные языки: ru и en');

            return Command::INVALID;
        }

        $file = __DIR__ . '/../../var/site_language.txt';

        if (file_put_contents($file, $language) === false) {
            $output->writeln('Не удалось изменить язык');

            return Command::FAILURE;
        }

        $output->writeln('Язык сайта изменён на: ' . $language);

        return Command::SUCCESS;
    }
}