<?php

namespace App\Service;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function getStudents(): array
    {
        return $this->entityManager
            ->getRepository(Student::class)
            ->findAll();
    }

    public function addStudent(string $name): void
    {
        $student = new Student();

        $student->setName($name);

        $this->entityManager->persist($student);
        $this->entityManager->flush();
    }
}