<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->users_model->Secure(array('type_2' => 'admin'))){
			$this->session->flashdata('flasherror', 'You must be logged into a valid admin account to access the admin area.');
			redirect('admin/login');
		}
		$this->load->model('admin/category_model');
	}

	// LIST CATEGORIES
	public function index($offset = 0){
		
		$this->load->library('pagination');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/category/index/';
		$config['total_rows'] 		= $this->category_model->GetCategories(array('count' => true));
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 4;
		$config['first_link'] 		= false;
		$config['last_link'] 		= false;
		$config['next_link'] 		= 'Seguinte';
		$config['prev_link'] 		= 'Anterior';
		
		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['records'] = $this->category_model->GetCategories(array('limit' => $perpage, 'offset' => $offset));
		
		$data['main_content'] = 'admin/category_view';
		$data['action'] = 'list';
		$data['current_page'] = 'category';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD CATEGORY
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		$this->load->model('admin/Category_model');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('categoryname', 'Nome', 'trim|required');
		$this->form_validation->set_rules('categorydescription', 'Descrição', 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$new_category = $this->category_model->AddCategory($_POST);
			
			if ($new_category) {
				$this->session->set_flashdata('flashConfirm', 'A categoria foi criada com sucesso!');
				redirect('admin/category');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro na base de dados ao adicionar a categoria!');
				redirect('admin/category');
			}
		}
		else{
			$data['records'] = $this->category_model->GetCategories();
			$data['action'] = 'add';
			$data['current_page'] = 'category';
			$data['main_content'] = 'admin/category_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	
	// EDIT CATEGORY 
	public function edit($idcategory){
		
		//load dependencies
		$this->load->model('admin/Category_model');
		$this->load->library('form_validation');
		
		$data['category'] = $this->category_model->GetCategories(array('idcategory' => $idcategory));
		if(!$data['category']) redirect('admin/category');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('categoryname', 'Nome', 'trim|required');
		$this->form_validation->set_rules('categorydescription', 'Descrição', 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['idcategory'] = $idcategory;
			if ($this->Category_model->UpdateCategory($_POST)) {
				$this->session->set_flashdata('flashConfirm', 'A categoria foi editada com sucesso!');
				redirect('admin/category');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro ao editar a categoria!');
				redirect('admin/category');
			}
		}
		$data['current_page'] = 'category';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/category_view';
		$this->load->view('admin/template/template', $data);
	}
	
	// DELETE CATEGORY
	public function delete($idcategory){
		
		//load dependencies
		$this->load->model('admin/category_model');
		$this->load->model('admin/menus_model');
		
		
		$data['category'] = $this->category_model->GetCategories(array('idcategory' => $idcategory));
		if(!$data['category']) redirect('admin/category');
		
		$active_category = $this->menus_model->GetMenus(array('idcategory' => $idcategory));
		
		if (!empty($active_category)){
			
			$this->session->set_flashdata('flashError', 'Esta categoria est&aacute; associada a um menu. N&atilde;o pode ser apagada.'); 
			redirect('admin/category');
			
		} 
		
		$this->category_model->UpdateCategory(array(
				'idcategory' 		=> $idcategory,
				'categorystatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', 'A Categoria foi apagada com sucesso.');
		redirect('admin/category');
	}
	
}