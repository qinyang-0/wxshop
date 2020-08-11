<?php


if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class Group_buyModule extends WeModule
{
	
	public function welcomeDisplay()
	{
        header("Location:".$this->createWebUrl('overview'));exit;
	}
}

?>