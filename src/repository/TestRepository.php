<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Test.php';

class TestRepository extends Repository
{

    public function getTest(int $id): ?Test
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.tests WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $test = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($test == false) {
            return null;
        }

        return new Test(
            $test['title'],
            $test['description'],
            $test['image']
        );
    }

    public function addTest(Test $test): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tests (title, description, image,  id_assigned_by)
            VALUES (?, ?, ?,  ?)
        ');

        //TODO you should get this value from logged user session
        $assignedById = 1;

        $stmt->execute([
            $test->getTitle(),
            $test->getDescription(),
            $test->getImage(),

            $assignedById
        ]);
    }

    public function getTests(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tests;
        ');
        $stmt->execute();
        $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tests as $test) {
            $result[] = new Test(
                $test['title'],
                $test['description'],
                $test['image'],
                $test['like'],
                $test['dislike'],
                $test['id']
            );
        }

        return $result;
    }

    public function getTestByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tests WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function like(int $id) {
        $stmt = $this->database->connect()->prepare('
            UPDATE tests SET "like" = "like" + 1 WHERE id = :id
         ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function dislike(int $id) {
        $stmt = $this->database->connect()->prepare('
            UPDATE tests SET dislike = dislike + 1 WHERE id = :id
         ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}