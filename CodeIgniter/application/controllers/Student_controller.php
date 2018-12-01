<?php
Class Student_controller extends CI_Controller{
	function __construct(){
		parent:: __construct();
		$this->load->helper("url");
		$this->load->database();
	}
	public function index(){
		$query = $this->db->get("student");
		$data['records'] = $query->result();
		$this->load->helper('url');
		$this->load->view('Student_view');
	}
	public function addStudentView(){
		$this->load->helper('form');
		$this->load->view('Student_add');

	}
	public function addStudent(){
		$this->load->model('Student_model');
		$data = array(
			'roll_no' => $this->input->post('roll_no');
			'name' => $this->input->post('name')

			)
		$this->Student_model->insert($data);
		$query = $this->db->get('Student');
		$data['records'] = $query->result();
		$this->load->view('Student_view',$data);
	}
	public function deleteStudent(){
		$this->load->model('Student_model');
		$roll_no = $this->uri->segmeny('3');
		$this->Student_model->delete($roll_no);

		$query=$this->db->get("Student");
		$data['records'] = $query->result();

		$this->load->view('Student_view',$data);
	}

	public function updateStudentView(){
		$this->load->model('Student_model');
		$roll_no = $this->uri->segmeny('3');
		$query = $this->db->get_where("student", array("roll_no"=>$roll_no));
		$data['records']= $query->result();
		$data['old_roll_no'] = $roll_no;
		$this->load->view('Student_edit',$data);
	}
}

?>