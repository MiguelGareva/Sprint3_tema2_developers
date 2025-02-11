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
        $tasks = json_decode($dbJson, true);
        if(!$tasks){
            $tasks = [];
        } foreach($tasks as $task){
            $alltasks[$task['id']] = $task;
        }
        return $alltasks;
    }
}
?>