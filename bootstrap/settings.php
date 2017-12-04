<?php
$dbConf = 'dbconf.ini';
$confArr = parse_ini_file($dbConf, true);

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host']   = $confArr['db-host'];
$config['db']['user']   = $confArr['db-user'];
$config['db']['pass']   = $confArr['db-pass'];
$config['db']['dbname'] = $confArr['db-name'];