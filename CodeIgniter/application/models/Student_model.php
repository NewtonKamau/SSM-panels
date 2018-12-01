<?php
	Class Student_model extends CI_Model{

		function __construct(){
			parent:: __construct();

		}
		//insert a record to the db
		public function insert($data){
			if ($this->db->insert("Student", $data)) {
				return true;
			}
		}
		//delete a specified record from the dbs
		public function delete($roll_no){
			if ($this->db->delete("Student", "roll_no=", $roll_no));
			return true;
			}
			//update an existing record
			public function update($data,$old_roll_no){
				$this->db-set($data);
				$this->db->where("roll_no",$old_roll_no);
				$this->db->update("Student",$data);			}
		}
	}

?>
