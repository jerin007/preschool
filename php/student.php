<?php
	header('Content-type: application/json');
	header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

    include('connection.php');

    class Student{ 
        public $db;

        function __construct() {
            $pdo_all = database::getInstance()->getConnection();
            //$this->db = $pdo_all['pdo_sct_hr'];
            $this->db = $pdo_all['pdo_base'];
        }

        function save_student($data){
            
            // $lname = $this->db->quote($data->lname);
            // $join_date = $this->db->quote($data->join_date);
            // $subject = $this->db->quote($data->subject);
            // $gender = $this->db->quote($data->gender);
            // $class = $this->db->quote($data->class);
            // $religion = $this->db->quote($data->religion);
            // $father_name = $this->db->quote($data->father_name);
            // $mother_name = $this->db->quote($data->mother_name);
            // $father_occupation = $this->db->quote($data->father_occupation);
            // $mother_occupation = $this->db->quote($data->mother_occupation);
            // $nationality =$this->db->quote($data->nationality);
            // $present_address = $this->db->quote($data->present_address);
            // $parmanent_address = $this->db->quote($data->parmanent_address);
            
            
            if($data->id > 0 ){
                $sql = 'UPDATE `s_infos` SET `firstname`='.$this->db->quote($data->firstname).',`lastname`='.$this->db->quote($data->lastname).',`joining_date`='.$this->db->quote($data->joining_date).',`subject`='.$this->db->quote($data->subject).',`mobile`='.$data->mobile.',`gender`='.$this->db->quote($data->gender).',`admission_no`='.$data->admission_no.',`birth_date`='.$this->db->quote($data->birth_date).',`student_id`='.$data->student_id.',`class`='.$this->db->quote($data->class).',`section`='.$this->db->quote($data->section).',`religion`='.$this->db->quote($data->religion).',`father_name`='.$this->db->quote($data->father_name).',`mother_name`='.$this->db->quote($data->mother_name).',`father_occupation`='.$this->db->quote($data->father_occupation).',`mother_occupation`='.$this->db->quote($data->mother_occupation).',`parents_mobile`='.$data->parents_mobile.',`nationality`='.$this->db->quote($data->nationality).',`present_address`='.$this->db->quote($data->present_address).',`parmanent_address`='.$this->db->quote($data->parmanent_address).'  WHERE id = '.$data->id;
            }else{
                $sql = "INSERT INTO `s_infos`( `firstname`, `lastname`, `joining_date`,  `subject`, `mobile`, `gender`, `admission_no`, `birth_date`, `student_id`, `class`, `section`, `religion`, `father_name`, `mother_name`, `father_occupation`, `mother_occupation`, `parents_mobile`, `nationality`, `present_address`, `parmanent_address`) VALUES
                ( ".$this->db->quote($data->firstname).", ".$this->db->quote($data->lastname).",
                ".$this->db->quote($data->joining_date).", 
                ".$this->db->quote($data->subject).", ".$data->mobile.", 
                ".$this->db->quote($data->gender).",". $data->admission_no.", 
                ".$this->db->quote($data->birth_date).", ". $data->student_id.", 
                ".$this->db->quote($data->class).", ".$this->db->quote($data->section).",
                ".$this->db->quote($data->religion).",".$this->db->quote($data->father_name).", 
                ".$this->db->quote($data->mother_name).", ".$this->db->quote($data->father_occupation).", 
                ".$this->db->quote($data->mother_occupation).",". $data->parents_mobile.",  ".$this->db->quote($data->nationality).", 
                ".$this->db->quote($data->present_address).", ".$this->db->quote($data->parmanent_address)." )";
            }
            // echo $sql;die();

			$result=$this->db->prepare($sql);
            // $result->execute();
            if($result->execute()) {
                return "1";
            } else{
                $result = "error in inserting into table s_info";
                return $result;
            } 
        }
        
        function get_student_details($id){
            $sql = "SELECT * FROM `s_infos` WHERE id = ".$id;
            $query = $this->db->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ);
            $data = $query->fetch();
            return $data;
        }
        // function edit_student($data){
        //     $fname = $this->db->quote($fname);
        //     $lname = $this->db->quote($lname);
        //     // $password = $this->db->quote($password);
        //     $subject = $this->db->quote($subject);
        //     $gender = $this->db->quote($gender);
        //     $class = $this->db->quote($class);
        //     $religion = $this->db->quote($religion);
        //     $father_name = $this->db->quote($father_name);
        //     $mother_name = $this->db->quote($mother_name);
        //     $father_occupation = $this->db->quote($father_occupation);
        //     $mother_occupation = $this->db->quote($mother_occupation);
        //     $nationality =$this->db->quote($nationality);
        //     $present_address = $this->db->quote($present_address);
        //     $parmanent_address = $this->db->quote($parmanent_address);

        //     $sql = "UPDATE `s_infos` SET `firstname`=$fname,`lastname`=$lname,`joining_date`=$join_date,`subject`=$subject,`mobile`=$mobile,`gender`=$gender,`admission_no`=$admission_no,`birth_date`=$birth_date,`student_id`=$student_id,`class`=$class,`section`=$section,`religion`=$religion,`father_name`=$father_name,`mother_name`=$mother_name,`father_occupation`=$father_occupation,`mother_occupation`=$mother_occupation,`parents_mobile`=$parents_mobile,`nationality`=$nationality,`present_address`=$present_address,`parmanent_address`=$parmanent_address  WHERE id = $id";

		// 	$result=$this->db->prepare($sql);
        //     if($result->execute()) {
        //         return "1";
        //     } else{
        //         $result = "error in Updating table s_info";
        //         return $result;
        //     } 
        // }

        function get_student_data($take, $skip){
            if($take == "all"){
	            $query ="SELECT * from s_infos";
	        }else{
	            $query ="SELECT * from s_infos LIMIT $skip,$take";
	        }
            $data = $this->db->prepare($query);
            $data->execute();
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $result = $data->fetchAll();
            $total = sizeof($result);
            $data_result = array('records' => $result, 'total' => $total);
            // echo $data_result;die();
            return $data_result;
        }
    }


