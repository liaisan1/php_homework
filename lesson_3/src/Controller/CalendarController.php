<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar/{format}/{month}', name: 'app_calendar', defaults: ['format' => 'table', 'month' => null])]
    public function calendar(string $format = 'table', ?int $month = null): Response
    {
        // Если месяц не указан, берем текущий
        if ($month == null) {
            $month = date('n');
        }

        // Проверяем месяц
        if ($month < 1 || $month > 12) {
            return new Response('Ошибка: месяц должен быть от 1 до 12');
        }

        $year = date('Y');

        // Количество дней в месяце
        $days = date('t', strtotime($year . '-' . $month . '-01'));

        // День недели первого числа
        $firstDay = date('N', strtotime($year . '-' . $month . '-01'));

        $weekDays = [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье'
        ];

        $daysList = [];

        // Создаем список дней
        for ($day = 1; $day <= $days; $day++) {

            $dayNumber = date(
                'N',
                strtotime($year . '-' . $month . '-' . $day)
            );

            $daysList[] = [
                'number' => $day,
                'name' => $weekDays[$dayNumber],
                'weekDay' => $dayNumber
            ];
        }

        // Выбираем нужный шаблон
        if ($format == 'list') {
            return $this->render('calendar/list.html.twig', [
                'daysList' => $daysList
            ]);
        }

        if ($format == 'weekends') {
            return $this->render('calendar/weekends.html.twig', [
                'daysList' => $daysList,
                'firstDay' => $firstDay
            ]);
        }

        // По умолчанию обычная таблица
        return $this->render('calendar/table.html.twig', [
            'days' => $days,
            'firstDay' => $firstDay
        ]);
    }
}