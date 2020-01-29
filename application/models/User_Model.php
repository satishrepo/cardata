<?php
	class User_Model extends CI_Model{
		public function register($encrypt_password){

			$data = array('name' => $this->input->post('name'), 
						  'email' => $this->input->post('email'),
						  'password' => $encrypt_password,
						  'username' => $this->input->post('username'),
						  'zipcode' => $this->input->post('zipcode')
						  );

			return $this->db->insert('users', $data);
		}

		public function login($email, $encrypt_password){
			//Validate
			$this->db->where('email', $email);
			$this->db->where('password', $encrypt_password);

			$result = $this->db->get('users');
			
			if ($result->num_rows() == 1) {
				return $result->row(0);
			}else{
				return false;
			}
		}

		// Check Username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));

			if(empty($query->row_array())){
				return true;
			}else{
				return false;
			}
		}

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));

			if(empty($query->row_array())){
				return true;
			}else{
				return false;
			}
		}

		public function change_password($userId, $old_password, $new_password)
		{
			
			$query = $this->db->get_where('users', 
				array(
					'id' => $userId, 'password' => md5($old_password)
				));
			
			if($query->num_rows() > 0) {

				$data = array( 'password' => md5($new_password));
				$this->db->where('id', $userId);
				if($this->db->update('users', $data)) {
					return '';
				} else {
					return 'Something went wrong try again later.';
				}
				
			} else {
				return 'Invalid old password.';
			}
		}
	}