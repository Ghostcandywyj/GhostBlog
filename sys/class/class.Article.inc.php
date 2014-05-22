<?php

class Article extends DB_Connect {


	public function __construct(){
		parent::__construct();
	}
	
	public function saveArticle($title,$tags,$article,$time){
		$sql = "INSERT INTO article (title,tags,content,time,readtime) VALUES 
			('".$title."','".$tags."','".$article."','".$time."',0);
		";
		if (!mysql_query($sql,$this->root_conn))
		{
			return false;
		}
		return true;
	}
	
	public function changeArticle($id,$title,$tags,$article,$time){
		$sql = 'UPDATE article SET 
			title="'.$title.'",tags="'.$tags.'",content="'.$article.'",time="'.$time.'"
			WHERE id="'.$id.'"';
		if (!mysql_query($sql,$this->root_conn))
		{
			return false;
		}
		return true;
		
	}
	
	public function readArticle($q){
		$sql = "SELECT * FROM article WHERE id='".$q."'";
		$select=mysql_query($sql,$this->root_conn) or trigger_error(mysql_error(),E_USER_ERROR);
		$result=mysql_fetch_assoc($select);
		
		$str = '%s$ge#%s$ge#%s';
		
		$return = sprintf($str,$result['title'],$result['tags'],$result['content']);
		return $return;
	}

}
?>