<?php

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
require_once('include/entryPoint.php');

function getPDOConnection()
{
    global $sugar_config;

    $host = $sugar_config['dbconfig']['db_host_name'];
    $username = $sugar_config['dbconfig']['db_user_name'];
    $password = $sugar_config['dbconfig']['db_password'];
    $database = $sugar_config['dbconfig']['db_name'];

    $port = $sugar_config['dbconfig']['db_port'];
    if (!$port) {
        $port = "3306";
    }

    $conn = new PDO("mysql:host=$host;dbname=$database;port=$port", $username, $password);
    return $conn;
}

function createStoredFunction()
{
    $conn = getPDOConnection();
    if($conn){
        $query = "getAge.sql";
        $contents = file_get_contents($query);
        $stmt = $conn->prepare($contents);
        $res = $stmt->execute();
        if (!$res){
            return "failed to install stored function \n";
        }else{
            return "successfully installed stored function \n";
        }
    }

}

print_r(createStoredFunction());
