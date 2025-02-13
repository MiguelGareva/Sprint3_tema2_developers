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
}