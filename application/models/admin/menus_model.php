<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Menus_Model
 * 
 * @package Menus
 * 
 */

class Menus_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Menus Methods **/
	
	/*
	 * AddMenu 
	 * 
	 * Option: Values
	 * --------------
	 * menuname 		=> required
	 * menutype			=> required
	 * menudescription	=> required
	 * parent
	 * menustatus
	 * 
	 * @param array $options
	 * @result int insert_id()
	 */
	
	function AddMenu($options = array()) {
		//required Values
		if(!$this->_required(
			array('menuname', 'menudescription', 'menutype'),
			$options
		)) return false;
		
		$options = $this->_default(array('menustatus' => 'active'), $options);
		
		
		$this->db->insert('menus', $options);
		
		return $this->db->insert_id();
	}
	
	/*
	 * UpdateMenus 
	 * 
	 * Option: Values
	 * --------------
	 * idmenu		=> required
	 * menuname 	
	 * menudescription	
	 * menustatus		
	 * 
	 * @param array $options
	 * @result int affected_rows()
	 */
	
	function UpdateMenu($options = array()) {
		//required Values
		if(!$this->_required(
			array('idmenu'),
			$options
		)) return false;
		
		if (isset($options['menuname']))
			$this->db->set('menuname', $options['menuname']);
			
		if (isset($options['menudescription']))
			$this->db->set('menudescription', $options['menudescription']);
			
		if (isset($options['menustatus']))
			$this->db->set('menustatus', $options['menustatus']);
		
		$this->db->where('idmenu', $options['idmenu']);
		$this->db->update('menus');
		
		return $this->db->affected_rows();
		
	}
	
	/*
	 * GetMenus
	 * 
	 * Option: Values
	 * --------------
	 * idmenu
	 * menuname
	 * menustatus
	 * parent
	 * category			(so the user can't delete a menu with an active category)
	 * limit			limit the returned records
	 * offset			bypass this many records
	 * sortBy			sort by this column
	 * sortDirection	(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
 	 * idmenu		
	 * menuname	
	 * menudescription
	 * menustatus
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetMenus($options = array()) {
		
		// QUALIFICATION
		if (isset($options['idmenu']))
			$this->db->where('idmenu', $options['idmenu']);		
		if (isset($options['menuname']))
			$this->db->where('menuname', $options['menuname']);		
		if (isset($options['menudescription']))
			$this->db->where('menudescription', $options['menudescription']);			
		if (isset($options['menustatus']))
			$this->db->where('menustatus', $options['menustatus']);
		if (isset($options['parent']))
			$this->db->where('parent', $options['parent']);
		if (isset($options['idcategory']))
			$this->db->where('idcategory', $options['idcategory']);	
		if (isset($options['idarticle']))
			$this->db->where('idarticle', $options['idarticle']);						

		//so you don't get any deleted values
		if(!isset($options['menustatus'])) $this->db->where('menustatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('menus');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idmenu']))
			return $query->row(0);
	
		return $query->result();
		
	}
	
}