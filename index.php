<?php
session_start();
// router
// Dựa vào tham số url để quyết định chạy hàm nào của controller nào
// tham số đó ta quy định
// c là đại diện cho controller
// a là action đại diện cho hàm (function)

// muốn chạy hàm create() của SubjectController thì ta truyền:
// qlsvmvc.com?c=subject&a=create

$c = $_GET['c'] ?? 'student'; // subject
$a = $_GET['a'] ?? 'index'; // create

// import config & database
require 'config.php';
require 'connectDB.php';

// import model
require 'model/Student.php';
require 'model/StudentRepository.php';

require 'model/Subject.php';
require 'model/SubjectRepository.php';

require 'model/Register.php';
require 'model/RegisterRepository.php';

$strController = ucfirst($c) . "Controller"; //SubjectController

// import controller
// require controller/SubjectController.php
require "controller/$strController.php";

// $controler = new StudentController();
$controller = new $strController();

// $controller->create();
$controller->$a();