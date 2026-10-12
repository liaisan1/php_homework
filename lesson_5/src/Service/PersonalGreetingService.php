<?php

namespace App\Service;

class PersonalGreetingService
{
    public function __construct(
        private GreetingService $greetingService
    ) {
    }

    public function getGreetings(array $users): array
    {
        $greetings = [];

        foreach ($users as $user) {
            $greetings[] = $this->greetingService->getGreeting($user);
        }

        return $greetings;
    }
}