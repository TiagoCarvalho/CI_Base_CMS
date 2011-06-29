<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->users_model->Secure(array('type_2' => 'admin'))){
			$this->session->flashdata('flasherror', 'You must be logged into a valid admin account to access the admin area.');
			redirect('admin/login');
		}
		$this->load->model('admin/files_model');
	}
	
	
	// LIST FILES
	public function index($offset = 0){
		
		//load dependencies
		$this->load->model('files_model');
		
		$this->load->library('pagination');
		
		$perpage = 30;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/files/index/';
		if ($this->input->post('filter')) {
			$config['total_rows'] 		= $this->files_model->GetFiles(array('count' => true, 'filestatus' => 'active', 'filetype' => $this->input->post('filter')));
		}
		else{
			$config['total_rows'] 		= $this->files_model->GetFiles(array('count' => true, 'filestatus' => 'active'));
		}
		$config['num_links'] 		= 4;
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 4;
		$config['first_link'] 		= false;
		$config['last_link'] 		= false;
		$config['next_link'] 		= 'Seguinte';
		$config['prev_link'] 		= 'Anterior';
		
		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		
		if ($this->input->post('filter')) {
			$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'idfile', 'sortDirection' => 'DESC', 'filetype' => $this->input->post('filter')));
			$data['filter'] = $this->input->post('filter');
		}
		elseif ($this->input->post('order')) {
			$order = $this->input->post('order');
			switch ($order) {
				case 'date-down':
					$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'idfile', 'sortDirection' => 'ASC'));
					$data['order'] = $this->input->post('order');
				break;
				case 'date-up':
					$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'idfile', 'sortDirection' => 'DESC'));
					$data['order'] = $this->input->post('order');
				break;
				case 'alpha-down':
					$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'filename', 'sortDirection' => 'ASC'));
					$data['order'] = $this->input->post('order');
				break;
				case 'alpha-up':
					$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'filename', 'sortDirection' => 'DESC'));
					$data['order'] = $this->input->post('order');
				break;
				default:
					$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'idfile', 'sortDirection' => 'ASC'));
					$data['order'] = '';
				break;
			}
		}
		else{
			$data['records'] = $this->files_model->GetFiles(array('limit' => $perpage, 'offset' => $offset, 'sortBy' => 'idfile', 'sortDirection' => 'DESC'));
		}
		$data['main_content'] = 'admin/files_view';
		$data['action'] = 'list';
		$data['current_page'] = 'files';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD FILE
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		$this->load->model('files_model');
		
		$new_file = $this->files_model->AddFile($_POST);
		
		if ($new_file) {
			$this->session->set_flashdata('flashConfirm', 'O Ficheiro foi enviado com sucesso!');
			redirect('admin/files');
		}
		else {
			$this->session->set_flashdata('flashError', 'Houve um erro na base de dados ao adicionar o ficheiro!');
			redirect('admin/files');
		}
				
	}
	
	// EDIT FILE
	public function edit($idfile) {
	
		$data['file'] = $this->files_model->GetFiles(array('idfile' => $idfile));
		
		$data['main_content'] = 'admin/files_view';
		$data['action'] = 'edit';
		$data['current_page'] = 'files';
		$this->load->view('admin/template/template', $data);
		
		
	}
	
	// DELETE FILE
	public function delete($idfile){
		
		$data['file'] = $this->files_model->GetFiles(array('idfile' => $idfile));
		if(!$data['file']) redirect('admin/files');
		
		$this->files_model->UpdateFile(array(
				'idfile' 		=> $idfile,
				'filestatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', 'O Ficheiro foi apagado com sucesso.');
		redirect('admin/files');
	}
	
}