<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Test.php';
require_once __DIR__ . '/../repository/TestRepository.php';

class TestController extends AppController
{

    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $testRepository;

    public function __construct()
    {
        parent::__construct();
        $this->testRepository = new TestRepository();
    }

    public function tests()
    {
        $tests = $this->testRepository->getTests();
        $this->render('tests', ['tests' => $tests]);
    }

    public function addTest()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            // Tdod
            $test = new Test($_POST['title'], $_POST['description'], $_FILES['file']['name']);
            $this->testRepository->addTest($test);

            return $this->render('tests', [
                'messages' => $this->message,
                'tests' => $this->testRepository->getTests()
            ]);
        }

        return $this->render('add-test', ['messages' => $this->message]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->testRepository->getTestByTitle($decoded['search']));
        }
    }

    public function like(int $id) {
        $this->testRepository->like($id);
        http_response_code(200);
    }

    public function dislike(int $id) {
        $this->testRepository->dislike($id);
        http_response_code(200);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }
}
