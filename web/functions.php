<?php

function dd($data) {
	ob_start(); 
	echo '<pre>', var_dump($data), '</pre>';
	echo "\n" . preg_replace("/=>[\r\n\s]+/", "=> ", ob_get_clean());
	die;
}