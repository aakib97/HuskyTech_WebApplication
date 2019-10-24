<?php

require ($_SERVER['DOCUMENT_ROOT'] . '/external/blackboard.php');
//require ($_SERVER['DOCUMENT_ROOT'] . '/classes/Employee.class.php');

$break = '<br>';

$foo = authorize();

var_dump($foo);
