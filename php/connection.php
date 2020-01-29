<?php
	final class database {
	    private static $instance = NULL;
	    private $pdo_base;
	    private $all_pdo = array();

	    private function __construct() {
	        try {
	            $db = new PDO('mysql:host=localhost;dbname=jjahanc1_preschool', 'jjahanc1_root', 'Pheq^VwvAVjE');
			    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        }catch(PDOException $e) {
	            echo $e->getmessage();
	            die();
	        }
	        $this->pdo_base = $db;
	        $this->all_pdo = array(
	        	'pdo_base' => $this->pdo_base
	        );
	    }
	    public static function getInstance() {
	        static $instance = null;
	        if (self::$instance === NULL) {
	            $instance = new database();
	        }
	        return $instance;
	    }
	    function getConnection(){
	        return $this->all_pdo;
	    }
	}
?>