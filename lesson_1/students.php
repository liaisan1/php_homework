<?php

$lines = file("students.txt");
$students = [];

foreach ($lines as $line) {
    $data = explode(";", $line);

    $name = $data[0];
    $grades = explode(",", $data[1]);

    $average = ($grades[0] + $grades[1] + $grades[2]) / 3;

    $students[$name] = $average;
}

arsort($students);

foreach ($students as $name => $average) {
    echo $name . ": " . number_format($average, 2) . PHP_EOL;
}

$bestStudent = array_key_first($students);

echo "Лучший студент: " . $bestStudent;