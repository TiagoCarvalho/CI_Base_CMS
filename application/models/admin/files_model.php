<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Files_Model
 * 
 * @package Files
 * 
 */

class Files_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Files Methods **/
	
	/*
	 * AddFile 
	 * 
	 * Option: Values
	 * --------------
	 * filename 		=> required
	 * filetype			=> required
	 * filestatus
	 * 
	 * @param array $options
	 * @result int insert_id()
	 */
	
	function AddFile($options = array()) {
		
		$file = $_FILES['userfile'];
		if (!empty($file)) {
			//config upload
			$upload_config = array(
				'allowed_types' => 'jpg|jpeg|gif|png|pdf|zip|rar|txt|bmp',
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
				$options['filename'] = $image_data['file_name'];
				$options['filetype'] = $image_data['file_ext'];
				if ($options['filename'] == NULL || $options['filetype'] == NULL) return false;
				
			}
		}
		else{
			unset($_FILES['userfile']);
		}
		
		//required Values
		if(!$this->_required(
			array('filename', 'filetype'),
			$options
		)) return false;
		
		$options = $this->_default(array('filestatus' => 'active'), $options);
		
		
		$this->db->insert('files', $options);
		
		return $this->db->insert_id();
	}
	
	/*
	 * UpdateFile
	 * 
	 * Option: Values
	 * --------------
	 * idfile			=> required	
	 * menustatus		
	 * 
	 * @param array $options
	 * @result int affected_rows()
	 */
	
	function UpdateFile($options = array()) {
		//required Values
		if(!$this->_required(
			array('idfile'),
			$options
		)) return false;
		
		if (isset($options['filestatus']))
			$this->db->set('filestatus', $options['filestatus']);
		
		$this->db->where('idfile', $options['idfile']);
		$this->db->update('files');
		
		return $this->db->affected_rows();
		
	}
	
	/*
	 * GetFiles
	 * 
	 * Option: Values
	 * --------------
	 * idfile
	 * filename
	 * filestatus
	 * limit			limit the returned records
	 * offset			bypass this many records
	 * sortBy			sort by this column
	 * sortDirection	(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
 	 * idfile		
	 * filename	
	 * filetype
	 * filestatus
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetFiles($options = array()) {
		
		// QUALIFICATION
		if (isset($options['idfile']))
			$this->db->where('idfile', $options['idfile']);		
		if (isset($options['filename']))
			$this->db->where('filename', $options['filename']);		
		if (isset($options['filetype']))
			$this->db->where('filetype', $options['filetype']);			
		if (isset($options['filestatus']))
			$this->db->where('filestatus', $options['filestatus']);
		//so you don't get any deleted values
		if(!isset($options['filestatus'])) $this->db->where('filestatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('files');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idfile']))
			return $query->row(0);
	
		return $query->result();
		
	}
	
}