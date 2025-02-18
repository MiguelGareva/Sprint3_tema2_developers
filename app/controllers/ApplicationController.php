<?php
declare(strict_types=1);

class ApplicationController extends Controller
{
    private ModelTask $modelTask;

    public function __construct()
    {
        $this->modelTask = new ModelTask();
    }

    public function getModelTask(): ModelTask
    {
        return $this->modelTask;
    }

    // Método privado para manejar la validación y creación de la tarea
    private function handleTaskData(): array
    {
        return [
            'description' => $_POST['description'] ?? '',
            'status' => $_POST['status'] ?? '',
            'date_ini' => $_POST['date_ini'] ?? '',
            'date_end' => $_POST['date_end'] ?? '',
            'user' => $_POST['user'] ?? ''
        ];
    }

    public function indexAction(): void
    {
        $allTasks = $this->modelTask->getAllTasks();
        $this->view->allTasks = $allTasks;
    }

    public function createAction(): void {
        $this->view->error = null; // Asegurar que no haya errores previos

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
                $newTask = $this->handleTaskData();
                $this->modelTask->createTask($newTask); // Esto ya llama a validateTaskData()
                $this->redirectToHome();
        }

    }

    public function readAction(): void
    {
        $taskId = $_GET['id'] ?? null;
        if ($taskId !== null) {
            $task = $this->modelTask->getTaskById((int)$taskId);
            $this->view->task = $task;
        } else {
            // Manejo de error si no se pasa un ID válido
            $this->redirectToHome();
        }
    }

    public function updateAction(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            $task = $this->modelTask->getTaskById((int)$id);
            $this->view->task = $task;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $updateTask = array_merge(['id' => $id], $this->handleTaskData());
                    $this->modelTask->updateTask($updateTask);
                    $this->redirectToHome();
                } catch (Exception $e) {
                    $this->view->error = $e->getMessage();
                }
            }
        } else {
            // Manejo de error si no se pasa un ID válido
            $this->redirectToHome();
        }
    }

    public function deleteAction(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_delete"])) {
            $this->modelTask->deleteTask($id);
            $this->redirectToHome();
        }
    }

    // Redirección a la página principal
    private function redirectToHome(): void
    {
        header("Location: ./");
        exit();
    }
}
