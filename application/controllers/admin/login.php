<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback__check_login');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		
		if($this->form_validation->run()){
			if($this->users_model->Login(array('email' => $this->input->post('email'), 'password' => $this->input->post('password')))){
				redirect('admin/manage');
			}redirect('admin/login');
		}
		
		$data['main_content'] = 'admin/login_view';
		$this->load->view('admin/template/template', $data);
	}
	
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('admin/login');
	}
	
	public function _check_login($email) {
		
		if($this->input->post('password')){
			$user = $this->users_model->GetUsers(array('email' => $email, 'password' => md5($this->input->post('password')), 'userstatus' => 'active'));
			if($user) return true;
		}
		
		$this->form_validation->set_message('_check_login', 'Your username / password combination is invalid.');
		return false;
	}
		
}