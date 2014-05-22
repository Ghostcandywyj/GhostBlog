<?php
	$_BASE_PATH="../../";
	include_once '../../sys/core/init.inc.php';
	
	$operation = $_POST['operation'];
	
	if($operation == 'save'){
		$title = $_POST['title'];
		$tags = $_POST['tags'];
		$article = $_POST['article'];
		
		$date = date('Y-m-d H:i:s');
		$time = date('Y-m-d H:i:s',strtotime("$date +6 hour"));
		
		$a = new Article();
		$return = $a->saveArticle($title,$tags,$article,$time);
		if($return) echo 1;
		else echo 0;
	}
	else if($operation == 'change'){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$tags = $_POST['tags'];
		$article = $_POST['article'];
		
		$date = date('Y-m-d H:i:s');
		$time = date('Y-m-d H:i:s',strtotime("$date +6 hour"));
		
		$a = new Article();
		$return = $a->changeArticle($id,$title,$tags,$article,$time);
		if($return) echo 1;
		else echo 0;
	}
	else if($operation == 'read'){
		$q = $_POST['q'];
		$a = new Article();
		$return = $a->readArticle($q);
		echo $return;
	}
?>