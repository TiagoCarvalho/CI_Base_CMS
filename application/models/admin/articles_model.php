<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Articles_Model
 * 
 * @package Articles
 * 
 */

class Articles_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Articles Methods **/
	
	/*
	 * AddArticle 
	 * 
	 * Option: Values
	 * --------------
	 * articletitle 		=> required
	 * idcategory 			=> Foreign Key (default = 0)
	 * articleintro			=> required
	 * articledescription
	 * articleimage
	 * articlestatus
	 * 
	 * @param array $options
	 * @result int insert_id()
	 */
	
	function AddArticle($options = array()) {
		//required Values
		if(!$this->_required(
			array('articletitle', 'articleintro'),
			$options
		)) return false;
		
		$options = $this->_default(array('articlestatus' => 'active'), $options);
		
		$file = $_FILES['userfile'];
		if (!empty($file)) {
			//config upload
			$upload_config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => './public/images/articles/',
				'max_size' => 2500
			);
			//load dependecies
			$this->load->library('upload', $upload_config);
			$this->upload->do_upload('userfile');
			$image_data = $this->upload->data();
			if ( ! $this->upload->data()){
	    		echo $this->upload->display_errors();
			}
			else{
				//apend filename to the data array
				$options['articleimage'] = $image_data['file_name'];
			}
		}
		else{
			unset($_FILES['userfile']);
		}
		
		$this->db->insert('articles', $options);
		
		return $this->db->insert_id();
	}
	
	/*
	 * UpdateArticle 
	 * 
	 * Option: Values
	 * --------------
	 * idarticle			=> required
	 * idcategory			=> Foreign Key (default = 0)
	 * articletitle 	
	 * articleintro	
	 * articledescription
	 * articleimage		
	 * articlestatus
	 * 
	 * @param array $options
	 * @result int affected_rows()
	 */
	
	function UpdateArticle($options = array()) {
		//required Values
		if(!$this->_required(
			array('idarticle'),
			$options
		)) return false;
		
		if (isset($options['idcategory']))
			$this->db->set('idcategory', $options['idcategory']);
		
		if (isset($options['articletitle']))
			$this->db->set('articletitle', $options['articletitle']);
			
		if (isset($options['articleintro']))
			$this->db->set('articleintro', $options['articleintro']);
		
		if (isset($options['articledescription']))
			$this->db->set('articledescription', $options['articledescription']);
			
		if (isset($options['articlestatus']))
			$this->db->set('articlestatus', $options['articlestatus']);
		
		$file = $_FILES['userfile'];
		if (!empty($file)) {
			//config upload
			$upload_config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => './public/images/articles/',
				'max_size' => 2500
			);
			//load dependecies
			$this->load->library('upload', $upload_config);
			$this->upload->do_upload('userfile');
			$image_data = $this->upload->data();
			if ( ! $this->upload->data()){
	    		echo $this->upload->display_errors();
			}
			else{
				//apend filename to the data array
				$this->db->set('articleimage', $image_data['file_name']);
			}
		}
		else{
			unset($_FILES['userfile']);
		}
			
			
		$this->db->where('idarticle', $options['idarticle']);
		$this->db->update('articles');
		
		return $this->db->affected_rows();
		
	}
	
	/*
	 * GetArticles
	 * 
	 * Option: Values
	 * --------------
	 * idarticle
	 * idcategory			=> Foreign Key (default = 0)
	 * articletitle
	 * articlestatus
	 * limit			limit the returned records
	 * offset			bypass this many records
	 * sortBy			sort by this column
	 * sortDirection	(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
	 * idarticle
	 * idcategory			=> Foreign Key (default = 0)
	 * articletitle
	 * articleintro
	 * articledescription
	 * articleimage
	 * articlestatus
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetArticles($options = array()) {
		
		// QUALIFICATION
		if (isset($options['idarticle']))
			$this->db->where('idarticle', $options['idarticle']);		
		if (isset($options['idcategory']))
			$this->db->where('idcategory', $options['idcategory']);		
		if (isset($options['articletitle']))
			$this->db->where('articletitle', $options['articletitle']);			
		if (isset($options['articlestatus']))
			$this->db->where('articlestatus', $options['articlestatus']);				

		//so you don't get any deleted values
		if(!isset($options['articlestatus'])) $this->db->where('articlestatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('articles');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idarticle']))
			return $query->row(0);
	
		return $query->result();
		
	}
	
}