<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->users_model->Secure(array('type_2' => 'admin'))){
			$this->session->flashdata('flasherror', 'You must be logged into a valid admin account to access the admin area.');
			redirect('admin/login');
		}
		$this->load->model('admin/articles_model');
	}

	// LIST CATEGORIES
	public function index($offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/category_model');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/menu/index/';
		$config['total_rows'] 		= $this->articles_model->GetArticles(array('count' => true));
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 4;
		$config['first_link'] 		= false;
		$config['last_link'] 		= false;
		$config['next_link'] 		= 'Seguinte';
		$config['prev_link'] 		= 'Anterior';
		
		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['categories'] = $this->category_model->GetCategories();
		$data['records'] = $this->articles_model->GetArticles(array('limit' => $perpage, 'offset' => $offset));
		
		$data['main_content'] = 'admin/articles_view';
		$data['action'] = 'list';
		$data['current_page'] = 'articles';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD CATEGORY
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('articletitle', 'Titulo', 'trim|required');
		$this->form_validation->set_rules('articleintro', 'Introdução', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('articledescription', 'Descrição', 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			
			$new_article = $this->articles_model->AddArticle($_POST, $_FILES);
			
			if ($new_article) {
				$this->session->set_flashdata('flashConfirm', 'O Artigo foi criado com sucesso!');
				redirect('admin/articles');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro na base de dados ao adicionar o Artigo!');
				redirect('admin/articles');
			}
		}
		else{
			$data['records'] 	= $this->articles_model->GetArticles();
			$data['categories'] = $this->category_model->GetCategories(); 
			$data['action'] = 'add';
			$data['current_page'] = 'articles';
			$data['main_content'] = 'admin/articles_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	
	// EDIT CATEGORY 
	public function edit($idarticle){
		
		//load dependencies
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		$this->load->library('form_validation');
		
		$data['article'] 	= $this->articles_model->GetArticles(array('idarticle' => $idarticle));
		$data['categories'] = $this->category_model->GetCategories();
		if(!$data['article']) redirect('admin/articles');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('articletitle', 'Titulo', 'trim|required');
		$this->form_validation->set_rules('articleintro', 'Introdução', 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['idarticle'] = $idarticle;
			if ($this->articles_model->UpdateArticle($_POST, $_FILES)) {
				$this->session->set_flashdata('flashConfirm', 'O Artigo foi editado com sucesso!');
				redirect('admin/articles');
			}
			else {
				$this->session->set_flashdata('flashError', 'Houve um erro ao editar o Artigo!');
				redirect('admin/articles');
			}
		}
		$data['current_page'] = 'articles';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/articles_view';
		$this->load->view('admin/template/template', $data);
	}
	
	// DELETE CATEGORY
	public function delete($idarticle){
		
		//load dependencies
		$this->load->model('admin/articles_model');
		$this->load->model('admin/menus_model');
		
		$data['article'] = $this->articles_model->GetArticles(array('idarticle' => $idarticle));
		if(!$data['article']) redirect('admin/articles');
		
		$active_article = $this->menus_model->GetMenus(array('idarticle' => $idarticle));
		
		if (!empty($active_article)){
			
			$this->session->set_flashdata('flashError', 'Este artigo est&aacute; associado a um menu. N&atilde;o pode ser apagado.'); 
			redirect('admin/articles');
			
		} 
		
		$this->articles_model->UpdateArticle(array(
				'idarticle' 	=> $idarticle,
				'articlestatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', 'O Artigo foi apagado com sucesso.');
		redirect('admin/articles');
	}
	
}