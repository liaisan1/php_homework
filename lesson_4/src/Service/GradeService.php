<?php

namespace App\Service;

use App\Entity\Grade;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class GradeService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function addGrade(Student $student, int $value): void
    {
        $grade = new Grade();

        $grade->setValue($value);
        $grade->setStudent($student);

        $this->entityManager->persist($grade);
        $this->entityManager->flush();
    }

    public function getGrades(Student $student): array
    {
        return $this->entityManager
            ->getRepository(Grade::class)
            ->findBy(['student' => $student]);
    }
}