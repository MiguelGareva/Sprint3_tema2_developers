<?php
declare(strict_types=1);
class ApplicationController extends Controller {
    
    private ModelTask $modelTask;

    public function __construct(){
        $this->modelTask = new ModelTask();
    }
    public function getModelTask(): ModelTask {
        return $this->modelTask;
    }
    public function indexAction(): void {
        $allTasks = $this->modelTask->getAllTasks();
        $this->view->allTasks = $allTasks;
    }
    public function createAction(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newTask = [
                'description' => $_POST['description'] ?? '',
                'status' => $_POST['status'] ?? '',
                'date_ini' => $_POST['date_ini'] ?? '',
                'date_end' => $_POST['date_end'] ?? '',
                'user' => $_POST['user'] ?? ''
            ];
            $this->modelTask->createTask($newTask);
            header('Location: ./');
            exit();
        } 
    }
    public function readAction(): void{
        $taskId = $_GET['id'] ?? null;
        $task = $this->modelTask->getTaskById((int)$taskId);
        $this->view->task = $task;
        
    }
    public function updateAction():void{
        $id = $_GET['id'];
        $task = $this->modelTask->getTaskById((int)$id);
        $this->view->task = $task;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateTask = [
                'id' => $id,
                'description' => $_POST['description'],
                'status' => $_POST['status'],
                'date_ini' => $_POST['date_ini'],
                'date_end' => $_POST['date_end'],
                'user' => $_POST['user']
            ];
            $this->modelTask->updateTask($updateTask);
            header('Location: ./'); // Redirigir a la página principal
            exit();
        }
    }
}