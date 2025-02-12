<?php
declare(strict_types=1);
class ApplicationController extends Controller {
	
    private ModelTask $modelTask;

    public function __construct(){
        $this->modelTask = new ModelTask();
    }
    public function indexAction():void{
        $allTasks = $this->modelTask->getAllTasks();
        $this->view->allTasks = $allTasks;
    }
    public function createAction():void{
        
    }
}
