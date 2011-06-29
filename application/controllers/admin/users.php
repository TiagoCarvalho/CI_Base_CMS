<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->users_model->Secure(array('type_2' => 'admin'))){
			$this->session->flashdata('flasherror', 'You must be logged into a valid admin account to access the admin area.');
			redirect('admin/login');
		}
	}
	
	
	// LIST USERS
	public function index($offset = 0){
		
		$this->load->library('pagination');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/users/index/';
		$config['total_rows'] 		= $this->users_model->GetUsers(array('count' => true));
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 4;
		$config['first_link'] 		= false;
		$config['last_link'] 		= false;
		$config['next_link'] 		= 'Seguinte';
		$config['prev_link'] 		= 'Anterior';
		
		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['records'] = $this->users_model->GetUsers(array('limit' => $perpage, 'offset' => $offset));
		
		$data['main_content'] = 'admin/users_view';
		$data['action'] = 'list';
		$data['current_page'] = 'users';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD USER
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('ec_password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Nome', 'trim|required');
		$this->form_validation->set_rules('surname', 'Sobrenome', 'trim|required');
		
		if ($this->form_validation->run()) {
			//validation passes
			$new_user = $this->users_model->AddUser($_POST);
			
			if ($new_user) {
				$this->session->set_flashdata('flashConfirm', 'O utilizador foi criado com sucesso!');
				redirect('admin/users');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro na base de dados ao adicionar o utilizador!');
				redirect('admin/users');
			}
		}
		else{
			$data['records'] = $this->users_model->GetUsers();
			$data['action'] = 'add';
			$data['current_page'] = 'users';
			$data['main_content'] = 'admin/users_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	// EDIT USER 
	public function edit($iduser){
		
		$data['user'] = $this->users_model->GetUsers(array('iduser' => $iduser));
		if(!$data['user']) redirect('admin/users');
		//load dependencies
		$this->load->library('form_validation');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('ec_password', 'Password', 'trim|min_length[6]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Nome', 'trim|required');
		$this->form_validation->set_rules('surname', 'Sobrenome', 'trim|required');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['iduser'] = $iduser; 
			if(empty($_FILES['ec_password'])) unset($_FILES['ec_password']);
			if ($this->users_model->UpdateUser($_POST)) {
				$this->session->set_flashdata('flashConfirm', 'O utilizador foi editado com sucesso!');
				redirect('admin/users');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro ao editar o utilizador!');
				redirect('admin/users/');
			}
		}
		$data['current_page'] = 'users';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/users_view';
		$this->load->view('admin/template/template', $data);
	}
	
	// DELETE USER
	public function delete($iduser){
		
		$data['user'] = $this->users_model->GetUsers(array('iduser' => $iduser));
		if(!$data['user']) redirect('admin/users');
		
		$this->users_model->UpdateUser(array(
				'iduser' 		=> $iduser,
				'userstatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', 'O utilizador foi pagado com sucesso.');
		redirect('admin/users');
	}
	
}