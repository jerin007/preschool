
<?php

/* Created By Jerin Jahan (Date : 26.01.2020) */
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

require('teacher.php');
include('connection.php');
require_once("lib/Encoding.php");
use \ForceUTF8\Encoding;

if(array_key_exists('service', $_GET)&&!empty($_GET['service'])){
	$service = $_GET['service'];
	$teacher_data = new Teacher();
switch($service){
		case "get_teacher_data":
			$skip = $_GET['skip'];
			$take = $_GET['take'];
			$col_name = $_GET['col_name'];
			$data = $teacher_data->getTeacherData($skip,$take,$col_name);
            $data = Encoding::toUTF8($data);
			echo json_encode($data);
			break;
		case "get_teacher_details":
			$id = $_GET['id'];
			$data = $teacher_data->getTeacherDetails($id);
            $data = Encoding::toUTF8($data);
			echo json_encode($data);
			break;
		case "save_teacher_data":
		    //echo "enter";die();
			$post_data = json_decode($_POST['data']);
			$data = $teacher_data->saveTeacherData($post_data[0]);
			echo json_encode($data);
			break;
		case "delete_teacher_data":
			$id = json_decode($_GET['id']);
			$data = $teacher_data->deleteTeacherData($id);
			echo json_encode($data);
			break;
		default:
			$return_data=[];
			$return_data['status']=0;
			$return_data['msg']="Something Going Wrong!!!";
			echo json_encode($return_data);
	}
}else{
	Utility::redirect(Config::BASE_URL);
}

?>