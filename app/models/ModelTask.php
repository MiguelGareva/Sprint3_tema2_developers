<?php
declare(strict_types=1);

class ModelTask {
    protected array $tasks;
    private const DB_PATH = ROOT_PATH . '/app/models/db.json';

    public function __construct(){
        $this->tasks = $this->loadTasksFromFile();
    }

    // Método privado para cargar tareas desde el archivo
    private function loadTasksFromFile(): array {
        $dbJson = file_get_contents(self::DB_PATH);

        if ($dbJson === false) {
            throw new Exception("Base de datos no encontrada");
        }

        $tasks = json_decode($dbJson, true);

        if ($tasks === null) {
            throw new Exception("Error al decodificar el archivo JSON");
        }

        return $tasks;
    }

    // Método privado para guardar tareas en el archivo
    private function saveTasksToFile(array $tasks): void {
        $jsonTasks = json_encode($tasks, JSON_PRETTY_PRINT);

        if (file_put_contents(self::DB_PATH, $jsonTasks) === false) {
            throw new Exception("Error al guardar las tareas en la base de datos");
        }
    }

    // Obtener todas las tareas
    public function getAllTasks(): array {
        $alltasks = [];

        foreach ($this->tasks as $task) {
            $alltasks[$task['id']] = $task;
        }

        return $alltasks;
    }

    // Obtener un nuevo ID para la tarea
    public function getNewId(): int {
        $lastTask = end($this->tasks);
        return empty($this->tasks) ? 1 : $lastTask['id'] + 1;
    }

    // Validar los datos antes de crear o actualizar una tarea
    private function validateTaskData(array $taskData): void {
        if (empty($taskData['description'])) {
            throw new Exception('La descripción es obligatoria.');
        }

        if (empty($taskData['user'])) {
            throw new Exception('El usuario es obligatorio.');
        }

        if (empty($taskData['date_ini'])) {
            throw new Exception('La fecha de inicio es obligatoria.');
        }

        if (strtotime($taskData['date_end']) < strtotime($taskData['date_ini'])) {
            throw new Exception('La fecha de finalización no puede ser anterior a la fecha de inicio.');
        }
    }

    // Crear una nueva tarea
    public function createTask(array $newTask): void {
        // Validamos los datos antes de crear la tarea
        $this->validateTaskData($newTask);

        $newTask['id'] = $this->getNewId();
        $this->tasks[] = $newTask;
        $this->saveTasksToFile($this->tasks);
    }

    // Obtener una tarea por ID
    public function getTaskById(int $id): ?array {
        foreach ($this->tasks as $task) {
            if ($task['id'] === $id) {
                return $task;
            }
        }

        return null;
    }

    // Actualizar una tarea
    public function updateTask(array $updateTask): void {
        // Validamos los datos antes de actualizar la tarea
        $this->validateTaskData($updateTask);

        foreach ($this->tasks as $i => $task) {
            if ($task['id'] === (int)$updateTask['id']) {
                $this->tasks[$i] = $updateTask;
                break;
            }
        }

        $this->saveTasksToFile($this->tasks);
    }

    // Eliminar una tarea
    public function deleteTask(int $id): void {
        $data = $this->getAllTasks();
        unset($data[$id]);
  
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        file_put_contents(ROOT_PATH . '/app/models/db.json', $json);
    
    }
}
?>
