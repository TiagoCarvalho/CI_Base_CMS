<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Category_Model
 * 
 * @package Category
 * 
 */

class Category_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Category Methods **/
	
	/*
	 * AddCategory 
	 * 
	 * Option: Values
	 * --------------
	 * categoryname 		=> required
	 * categorydescription	=> required
	 * 
	 * @param array $options
	 * @result int insert_id()
	 */
	
	function AddCategory($options = array()) {
		//required Values
		if(!$this->_required(
			array('categoryname', 'categorydescription'),
			$options
		)) return false;
		
		$options = $this->_default(array('categorystatus' => 'active'), $options);
		
		$this->db->insert('category', $options);
		
		return $this->db->insert_id();
	}
	
	/*
	 * UpdateCategory 
	 * 
	 * Option: Values
	 * --------------
	 * idcategory		=> required
	 * categoryname 	
	 * categorydescription	
	 * categorystatus		
	 * 
	 * @param array $options
	 * @result int affected_rows()
	 */
	
	function UpdateCategory($options = array()) {
		//required Values
		if(!$this->_required(
			array('idcategory'),
			$options
		)) return false;
		
		if (isset($options['categoryname']))
			$this->db->set('categoryname', $options['categoryname']);
			
		if (isset($options['categorydescription']))
			$this->db->set('categorydescription', $options['categorydescription']);
			
		if (isset($options['categorystatus']))
			$this->db->set('categorystatus', $options['categorystatus']);
		
		$this->db->where('idcategory', $options['idcategory']);
		$this->db->update('category');
		
		return $this->db->affected_rows();
		
	}
	
	/*
	 * GetCategories
	 * 
	 * Option: Values
	 * --------------
	 * idcategory
	 * categoryname
	 * categorystatus
	 * limit			limit the returned records
	 * offset			bypass this many records
	 * sortBy			sort by this column
	 * sortDirection	(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
 	 * idcategory		
	 * categoryname	
	 * categorydescription
	 * categorystatus		
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetCategories($options = array()) {
		
		// QUALIFICATION
		if (isset($options['idcategory']))
			$this->db->where('idcategory', $options['idcategory']);		
		if (isset($options['categoryname']))
			$this->db->where('categoryname', $options['categoryname']);		
		if (isset($options['categorydescription']))
			$this->db->where('categorydescription', $options['categorydescription']);			
		if (isset($options['categorystatus']))
			$this->db->where('categorystatus', $options['categorystatus']);			

		//so you don't get any deleted values
		if(!isset($options['categorystatus'])) $this->db->where('categorystatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('category');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idcategory']))
			return $query->row(0);
	
		return $query->result();
		
	}
	
}