<?php 
declare(strict_types=1);

class ModelTask {
    protected array $tasks;
    private const DB_PATH = ROOT_PATH . '/app/models/db.json';

    public function __construct(){
        $this->tasks = [];
    }
    public function getAllTasks():array{
        $alltasks = [];
        $dbJson = file_get_contents(self::DB_PATH);

        if($dbJson === false){
            throw new Exception("Base de datos no encontrada");
        }

        $tasks = json_decode($dbJson, true);

        if(!$tasks){
            $tasks = [];
        }
         foreach($tasks as $task){
            $alltasks[$task['id']] = $task;
        }
        return $alltasks;
    }
    public function getNewId(): int{
        $allTasks = $this->getAllTasks();
        if(empty($allTasks)){
            return 1;
        }
        $lastTask = end($allTasks);
        $nextId = $lastTask['id'];
        $nextId++;
        return $nextId;
    }
    public function createTask(array $newTask):void{
        $allTasks = $this->getAllTasks();
        $newTask['id'] = $this->getNewId();
        $allTasks[]=$newTask;
        $jsonTasks = json_encode(array_values($allTasks), JSON_PRETTY_PRINT);
        file_put_contents(self::DB_PATH, $jsonTasks);
    }
    public function getTaskById(int $id): ?array{
        $allTasks = $this->getAllTasks();
        return $allTasks[$id] ?? null;
    }
    public function updateTask(array $updateTask): void{
        $allTasks = $this->getAllTasks();

        foreach($allTasks as $i => $task) {
            if((int)$task['id'] === (int)$updateTask['id']) {
                $allTasks[$i] = $updateTask;
            }
        }
        $jsonTasks = json_encode(array_values($allTasks), JSON_PRETTY_PRINT);
        file_put_contents(self::DB_PATH, $jsonTasks);
    }
}
?>