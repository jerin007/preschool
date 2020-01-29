<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

class Teacher {
	public $db;
	function __construct() {
        $pdo_all = database::getInstance()->getConnection();
        $this->db = $pdo_all['pdo_base'];
    }
	function __destruct(){
	}
	/* Get Teacher Data */
	function getTeacherData($skip,$take,$col_name){
		$data_result = [];
		$sql = "SELECT *,LEFT(firstname , 1) as firstletter FROM `teacher_infos`";
		$query = $this->db->prepare($sql);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		$total = sizeof($data);
		if($take != "all"){
			$data = array_slice($data, $skip, $take);
		}
		$return_data = [];
		if($col_name != "all"){
			$all_col_name = explode(',', $col_name);
			for($i = 0; $i < sizeof($data);$i++){
				for($j = 0; $j < sizeof($all_col_name);$j++){
					$return_data[$i][$all_col_name[$j]] = $data[$i][$all_col_name[$j]];
				}
			}
			$data = $return_data;
		}
		$data_result = array('records' => $data, 'total' => $total);
		return $data_result;
	}
	/* Get Teacher Details */
	function getTeacherDetails($id){
		$sql = "SELECT * FROM `teacher_infos` WHERE id = ".$id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_OBJ);
		$data = $query->fetch();
		return $data;
	}
	/* Save Teacher Data */
	function saveTeacherData($data){
		if($data==NULL){
			return;
		}else{
			// echo "<pre>";print_r($data);die();
			$id = $data->id;
			$sql;
			if($id > 0){
				$sql="UPDATE teacher_infos SET firstname=".$this->db->quote($data->firstname).", lastname=".$this->db->quote($data->lastname).", email=".$this->db->quote($data->email).", joining_date=".$this->db->quote($data->joining_date).", password=".$this->db->quote($data->password).", subject=".$this->db->quote($data->subject).", mobile=".$this->db->quote($data->mobile).", gender=".$this->db->quote($data->gender).", subject_id=".$this->db->quote($data->subject_id).", class=".$this->db->quote($data->class).", section=".$this->db->quote($data->section).", parmanent_address=".$this->db->quote($data->parmanent_address).", dateofbirth=".$this->db->quote($data->dateofbirth).", teacher_id=".$this->db->quote($data->teacher_id)." WHERE id=".$id;
			}else{
				$sql="INSERT INTO `teacher_infos` (`firstname`, `lastname`, `email`, `joining_date`, `password`, `subject`, `mobile`, `gender`, `subject_id`, `class`, `section`, `parmanent_address`, `dateofbirth`, `teacher_id`) VALUES (".$this->db->quote($data->firstname).", ".$this->db->quote($data->lastname).", ".$this->db->quote($data->email).", ".$this->db->quote($data->joining_date).", ".$this->db->quote($data->password).", ".$this->db->quote($data->subject).", ".$this->db->quote($data->mobile).", ".$this->db->quote($data->gender).", ".$this->db->quote($data->subject_id).", ".$this->db->quote($data->class).", ".$this->db->quote($data->section).", ".$this->db->quote($data->parmanent_address).", ".$this->db->quote($data->dateofbirth).", ".$this->db->quote($data->teacher_id).")";
			}
			// echo "<pre>";print_r($sql);die();
			$query=$this->db->prepare($sql);
			$query->execute();
			if($query) {
				if($id < 1){
					$id = $this->db->lastInsertId();
				}
				return $data;
			}else{
				header("HTTP/1.1 500 Internal Server Error");
				return "Failed on update: ";
			}
		}
	}
	/* Delete Teacher Data */
	function deleteTeacherData($id){
		$result = "error";
		$sql="DELETE FROM teacher_infos where id = ".$id." ";
		$query=$this->db->prepare($sql);
		$query->execute();
		if($query) {
			$result = "success";
		}else{
			$result = "error";
		}
		return $result;
	}
}

?>