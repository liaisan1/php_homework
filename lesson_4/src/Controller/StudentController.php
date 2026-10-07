<?php

namespace App\Controller;

use App\Entity\Student;
use App\Service\GradeService;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    // главная страница 
    #[Route('/journal')]
    public function journal(
        StudentService $studentService,
        GradeService $gradeService
    ): Response {
        $students = $studentService->getStudents();

        $grades = [];

        // для каждого студента получаем его оценки
        foreach ($students as $student) {
            $grades[$student->getId()] = $gradeService->getGrades($student);
        }

        return $this->render('journal/index.html.twig', [
            'students' => $students,
            'grades' => $grades
        ]);
    }

    // добавление нового студента
    #[Route('/student/add', methods: ['POST'])]
    public function addStudent(
        Request $request,
        StudentService $studentService
    ): Response {
        $name = $request->request->get('name');

        if ($name != '') {
            $studentService->addStudent($name);
        }

        return $this->redirect('/journal');
    }

    // добавление оценки студенту
    #[Route('/grade/add/{id}', methods: ['POST'])]
    public function addGrade(
        Student $student,
        Request $request,
        GradeService $gradeService
    ): Response {
        // получаем оценку из формы
        $value = (int) $request->request->get('grade');

        if ($value >= 1 && $value <= 5) {
            $gradeService->addGrade($student, $value);
        }

        return $this->redirect('/journal');
    }
}