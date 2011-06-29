<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * User_Model
 * 
 * @package Users
 * 
 */

class Users_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** User Methods **/
	
	/*
	 * AddUser 
	 * 
	 * Option: Values
	 * --------------
	 * username 	=> required
	 * ec_password	=> required
	 * email		=> required
	 * name			=> required
	 * surname		=> required
	 * website
	 * facebook
	 * twitter
	 * type_2
	 * userstatus
	 * 
	 * @param array $options
	 * @result int insert_id()
	 */
	
	function AddUser($options = array()) {
		//required Values
		if(!$this->_required(
			array('username', 'email', 'ec_password', 'name', 'surname', 'type_2'),
			$options
		)) return false;
		
		$options = $this->_default(array('userstatus' => 'active'), $options);
		
		$options['ec_password'] = md5($options['ec_password']);
		
		$this->db->insert('users', $options);
		
		return $this->db->insert_id();
	}
	
	/*
	 * UpdateUser 
	 * 
	 * Option: Values
	 * --------------
	 * iduser		=> required
	 * username 	
	 * ec_password	
	 * email		
	 * name			
	 * surname		
	 * website
	 * facebook
	 * twitter
	 * type_2
	 * userstatus
	 * 
	 * @param array $options
	 * @result int affected_rows()
	 */
	
	function UpdateUser($options = array()) {
		//required Values
		if(!$this->_required(
			array('iduser'),
			$options
		)) return false;
		
		if (isset($options['username']))
			$this->db->set('username', $options['username']);
			
		if (isset($options['ec_password']))
			$this->db->set('ec_password', md5($options['ec_password']));
			
		if (isset($options['email']))
			$this->db->set('email', $options['email']);
			
		if (isset($options['name']))
			$this->db->set('name', $options['name']);
			
		if (isset($options['surname']))
			$this->db->set('surname', $options['surname']);
			
		if (isset($options['website']))
			$this->db->set('website', $options['website']);
			
		if (isset($options['facebook']))
			$this->db->set('facebook', $options['facebook']);
			
		if (isset($options['twitter']))
			$this->db->set('twitter', $options['twitter']);
		
		if (isset($options['userstatus']))
			$this->db->set('userstatus', $options['userstatus']);
		
		$this->db->where('iduser', $options['iduser']);
		$this->db->update('users');
		
		return $this->db->affected_rows();
		
	}
	
	/*
	 * GetUsers 
	 * 
	 * Option: Values
	 * --------------
	 * iduser
	 * username
	 * userstatus
	 * limit			limit the returned records
	 * offset			bypass this many records
	 * sortBy			sort by this column
	 * sortDirection	(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
 	 * iduser		
	 * username 	
	 * ec_password	
	 * email		
	 * name			
	 * surname		
	 * website
	 * facebook
	 * twitter
	 * type_2
	 * userstatus
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetUsers($options = array()) {
		
		// QUALIFICATION
		if (isset($options['iduser']))
			$this->db->where('iduser', $options['iduser']);		
		if (isset($options['username']))
			$this->db->where('username', $options['username']);		
		if (isset($options['userstatus']))
			$this->db->where('userstatus', $options['userstatus']);			
		if (isset($options['email']))
			$this->db->where('email', $options['email']);
		if (isset($options['password']))
			$this->db->where('ec_password', $options['password']);			
		if (isset($options['type_2']))
			$this->db->where('type_2', $options['type_2']);
		//in case you want some deleted values
		if(!isset($options['userstatus'])) $this->db->where('userstatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('users');
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['iduser']))
			return $query->row(0);
	
		return $query->result();
		
	}
	
	
	/** Authentication Methods **/
	
	
	/*
	 * login 
	 *------
	 *The login method adds user database data to the session data.
	 *
	 *Option Values
	 *-------------
	 *email
	 *password
	 *
	 *@param array $options
	 *@return object result()
	 *
	 */ 
	
	
	function Login($options = array()) {
		//required Values
		if(!$this->_required(
			array('email', 'password'),
			$options
		)) return false;
		
		$returned_user = $this->GetUsers(array('email' => $options['email'], 'password' => md5($options['password'])));
		if(!$returned_user) return false;
		
		$sessiondata = array(
                   'email'  	=> $returned_user[0]->email,
				   'username'	=> $returned_user[0]->username,
                   'iduser'     => $returned_user[0]->iduser,
                   'name' 		=> $returned_user[0]->name,
				   'surname'	=> $returned_user[0]->surname,
				   'type_2' 	=> $returned_user[0]->type_2,
				   'logged_in'	=> true
               );
        $this->session->set_userdata($sessiondata);
		
		return true;
		
	}
	
	
	/*
	 * Secure method 
	 *------
	 *The Secure method checks if the user is loggued in.
	 *
	 *Option Values
	 *-------------
	 *type_2
	 *
	 *@param array $options
	 *@return bool
	 */ 
	
	function Secure($options = array()) {
		//required Values
		if(!$this->_required(
			array('type_2', 'type_2'),
			$options
		)) return false;
		
		
		$type_2 = $this->session->userdata('type_2');
		
		if(is_array($options['type_2'])){
			foreach ($options['type_2'] as $optionsUserType){
				
				if($optionsUserType == $type_2) return true;
				
			}
		}
		else{
			
			if($type_2 == $options['type_2']) return true;
			
		}
		
		return false;
		
	}
	
	
}