<?php

class Controller404 extends Controller
{

    public function actionIndex()
	{
		$this->view->generate('404_view.php', 'template_view.php');
	}

}
