<?php

namespace App\Service;

class EmailService
{
    public function __construct(
        private PersonalGreetingService $personalGreetingService,
        private string $senderEmail,
        private string $projectDir
    ) {
    }

    public function createEmails(array $users): int
    {
        $names = [];

        foreach ($users as $user) {
            $names[] = $user['name'];
        }

        $greetings = $this->personalGreetingService->getGreetings($names);

        $folder = $this->projectDir . '/var/emails';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        foreach ($users as $index => $user) {
            $message = "От: " . $this->senderEmail . "\n";
            $message .= "Кому: " . $user['email'] . "\n\n";
            $message .= $greetings[$index];

            $filename = $folder . '/email_' . uniqid() . '.txt';

            file_put_contents($filename, $message);
        }

        return count($users);
    }
}