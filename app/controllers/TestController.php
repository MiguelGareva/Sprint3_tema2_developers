<?php

class TestController extends ApplicationController
{
	public function testIndexAction()
	{
		$this->view->message = "hello from test::index";
	}
	
	public function checkAction()
	{
		echo "hello from test::check";
	}
}
