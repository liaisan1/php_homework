<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailController extends AbstractController
{
    #[Route('/emails')]
    public function index(): Response
    {
        return $this->render('emails/index.html.twig');
    }

    #[Route('/emails/create', methods: ['POST'])]
    public function create(
        Request $request,
        EmailService $emailService
    ): Response {
        $names = $request->request->all('names');
        $emails = $request->request->all('emails');

        $users = [];

        foreach ($names as $index => $name) {
            if ($name != '' && !empty($emails[$index])) {
                $users[] = [
                    'name' => $name,
                    'email' => $emails[$index]
                ];
            }
        }

        $count = $emailService->createEmails($users);

        return $this->render('emails/result.html.twig', [
            'count' => $count
        ]);
    }
}