<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalendarController
{
    #[Route('/calendar/{format}/{month}', name: 'calendar', defaults: ['format' => 'table', 'month' => null])]
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

        $html = "<h1>Календарь</h1>";

        // Список в столбик
        if ($format == 'list') {

            $weekDays = [
                1 => 'Понедельник',
                2 => 'Вторник',
                3 => 'Среда',
                4 => 'Четверг',
                5 => 'Пятница',
                6 => 'Суббота',
                7 => 'Воскресенье'
            ];

            for ($day = 1; $day <= $days; $day++) {

                $dayNumber = date(
                    'N',
                    strtotime($year . '-' . $month . '-' . $day)
                );

                $html .= $day . " - " . $weekDays[$dayNumber] . "<br>";
            }

        } else {

            // Обычная таблица с границами
            if ($format == 'table') {
                $html .= "<table border='1'>";
            } else {
                // Таблица без границ
                $html .= "<table>";
            }

            $html .= "<tr>";
            $html .= "<th>Пн</th>";
            $html .= "<th>Вт</th>";
            $html .= "<th>Ср</th>";
            $html .= "<th>Чт</th>";
            $html .= "<th>Пт</th>";
            $html .= "<th>Сб</th>";
            $html .= "<th>Вс</th>";
            $html .= "</tr>";

            $html .= "<tr>";

            // Пустые клетки до первого числа
            for ($i = 1; $i < $firstDay; $i++) {
                $html .= "<td></td>";
            }

            // Дни месяца
            for ($day = 1; $day <= $days; $day++) {

                $dayNumber = date(
                    'N',
                    strtotime($year . '-' . $month . '-' . $day)
                );

                // В формате weekends выходные красные
                if ($format == 'weekends' && $dayNumber >= 6) {
                    $html .= "<td style='color: red'>" . $day . "</td>";
                } else {
                    $html .= "<td>" . $day . "</td>";
                }

                // После воскресенья начинаем новую строку
                if (($day + $firstDay - 1) % 7 == 0) {
                    $html .= "</tr><tr>";
                }
            }

            $html .= "</tr>";
            $html .= "</table>";
        }

        return new Response($html);
    }
}