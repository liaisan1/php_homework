<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

try {
    // Первый запрос - получаем погоду
    $response = $client->get('https://wttr.in/London?format=j1', [
        'http_errors' => false,
        'verify' => false
    ]);

    // Проверяем статус
    if ($response->getStatusCode() != 200) {
        echo "Ошибка: сервер вернул код " . $response->getStatusCode();
        exit;
    }

    $body = $response->getBody();

    // Декодируем JSON
    try {
        $weather = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        echo "Ошибка JSON: " . $e->getMessage();
        exit;
    }

    // Берем первые 3 результата
    $firstThree = array_slice($weather["weather"], 0, 3);

    // Создаем новый массив
    $data = [
        "status" => $response->getStatusCode(),
        "results" => $firstThree
    ];

    // Создаем новый JSON
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    // Второй запрос - отправляем JSON
    $response2 = $client->post('https://jsonplaceholder.typicode.com/posts', [
        'headers' => [
            'Content-Type' => 'application/json'
        ],
        'body' => $json,
        'http_errors' => false,
        'verify' => false
    ]);

    // Проверяем второй запрос
    if ($response2->getStatusCode() != 201) {
        echo "Ошибка отправки: " . $response2->getStatusCode();
        exit;
    }

    // Выводим окончательный результат
    echo $response2->getBody();

} catch (Exception $e) {
    echo "Ошибка запроса: " . $e->getMessage();
}