<?php
	class Users extends CI_Controller
	{
		public function dashboard(){
			if(!$this->session->userdata('login')) {
				redirect('users/login');
			}
			$data['title'] = 'Dashboard';

			$this->load->view('templates/header');
			$this->load->view('users/dashboard', $data);
			$this->load->view('templates/footer');
		}

		// Register User
		public function register(){
			if($this->session->userdata('login')) {
				redirect('posts');
			}

			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			}else{
				//Encrypt Password
				$encrypt_password = md5($this->input->post('password'));

				$this->User_Model->register($encrypt_password);

				//Set Message
				$this->session->set_flashdata('user_registered', 'You are registered and can log in.');
				redirect('posts');
			}
		}

		// Log in User
		public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			}else{
				// get email and Encrypt Password
				$email = $this->input->post('email');
				$encrypt_password = md5($this->input->post('password'));

				$user_id = $this->User_Model->login($email, $encrypt_password);
				
				if ($user_id) {
					//Create Session
					$user_data = array(
								'user_id' => $user_id->id,
				 				// 'username' => $username,
				 				'email' => $user_id->email,
				 				'login' => true
				 	);

				 	$this->session->set_userdata($user_data);

					//Set Message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in.');
					redirect('users/dashboard');
				}else{
					$this->session->set_flashdata('login_failed', 'Invalid login details.');
					redirect('users/login');
				}
				
			}
		}

		// log user out
		public function logout(){
			// unset user data
			$this->session->unset_userdata('login');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');

			//Set Message
			$this->session->set_flashdata('user_loggedout', 'You are logged out.');
			redirect(base_url());
		}

		// Check user name exists
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is already taken, Please choose a different one.');

			if ($this->User_Model->check_username_exists($username)) {
				return true;
			}else{
				return false;
			}
		}


		// Check Email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'This email is already registered.');

			if ($this->User_Model->check_email_exists($email)) {
				return true;
			}else{
				return false;
			}
		}

		public function change_password()
		{
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('users');
			}

			$loggedUser = $this->session->userdata();
			$data['title'] = 'Change password';

			$this->form_validation->set_rules('old_password', 'Old Password', 'required');
			$this->form_validation->set_rules('new_password', 'New Password Field', 'required');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'matches[new_password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/change-password', $data);
				$this->load->view('templates/footer');
			}else{
				$rs = $this->User_Model->change_password(
					$loggedUser['user_id'], 
					$this->input->post('old_password'), 
					$this->input->post('new_password'));
				$rs = !$rs ? 'Password Has been changed successfull.' : $rs;
				$this->session->set_flashdata('success', $rs);
				redirect('users/change-password');
			}
			
	}

	function readCsv($path)
	{
		$loggedUser = $this->session->userdata;
        $this->load->library('csvreader');
        $result = $this->csvreader->parse_file($path, $loggedUser['user_id']);
        $this->db->insert_batch('cars', $result). ' ON DUPLICATE KEY UPDATE duplicate=UPDATE';
        // echo $this->db->last_query();
        // print_r($result);  
	}

	function uploadCsv() 
	{

		if(!$_FILES) {
			
			$this->load->view('templates/header');
			$this->load->view('users/csv-form');
			$this->load->view('templates/footer');
		}   
		else 
		{

			$config['upload_path'] = './assets/csvfiles';
			$config['allowed_types'] = 'csv';
			$config['max_size'] = '2048';
			
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload()){

				$errors =  array('error' => $this->upload->display_errors());

			}else{

				$data =  array('upload_data' => $this->upload->data());
				$fileName = str_replace(" ", "_", $_FILES['userfile']['name']);
			}
			
			$this->readCsv($config['upload_path'].'/'.$fileName);
			
			$this->session->set_flashdata('success', 'Data Imported Successfully.');
			redirect('users/import');
		}
	}

	public function download_csv_template() {
		$this->load->helper('download');
		force_download('./assets/csv-template.csv', NULL);
	}

	public function get_cars()
	{
		$data['products'] = $this->Administrator_Model->get_cars();
	
		$data['title'] = 'List Cars';

		$this->load->view('templates/header');
		$this->load->view('users/cars', $data);
		$this->load->view('templates/footer');
	}

	public function update_cars($id)
	{
		if(!$id){
			echo 'Invalid id';
		} else  {
			$data['carData'] = $this->Administrator_Model->get_cars($id);
		}

		if(empty($data['carData'])){
			echo 'invalid id';
		} 
		
		// Check login
		if(!$this->session->userdata('login')) {
			redirect('users/index');
		}
		$data['title'] = 'Update Car';

		$loggedUser = $this->session->userdata;

		$this->form_validation->set_rules('dealer', 'Service Dealer', 'required');
		$this->form_validation->set_rules('title', 'Service Title', 'required');
		$this->form_validation->set_rules('url', 'Service Url', 'required');
		$this->form_validation->set_rules('date', 'Service Date', 'required');
		// $this->form_validation->set_rules('image', 'Image', 'required');
		$this->form_validation->set_rules('blurb', 'Service Blurb', 'required');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/update-car', $data);
			$this->load->view('templates/footer');		
			
		}else{
			$update = array(
				'id' => $this->input->post('id'),
				'dealer' => $this->input->post('dealer'),
				'title' => $this->input->post('title'),
				'url' => $this->input->post('url'),
				'date' => $this->input->post('date'),
				'status' => $this->input->post('status'),
				'updated_by' => $loggedUser['user_id'],
				'updated_on' => date("Y-m-d H:i:s")
			);

			if($this->Administrator_Model->update_car($update)) {
				$this->session->set_flashdata('success', 'Car Updated Successfull.');
				redirect('users/cars');	
			} else {
				$this->load->view('templates/header');
				$this->load->view('users/update-car', $data);
				$this->load->view('templates/footer');			
			}

			
		}

	}

	public function delete($id)
	{
		$table = base64_decode($this->input->get('table'));
		//$table = $this->input->post('table');
		$this->Administrator_Model->delete($id,$table);       
		$this->session->set_flashdata('success', 'Data has been deleted Successfully.');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	public function enable($id)
	{
		$table = base64_decode($this->input->get('table'));
		//$table = $this->input->post('table');
		$this->Administrator_Model->enable($id,$table);       
		$this->session->set_flashdata('success', 'Disabled Successfully.');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	public function desable($id)
	{
		$table = base64_decode($this->input->get('table'));
		//$table = $this->input->post('table');
		$this->Administrator_Model->desable($id,$table);       
		$this->session->set_flashdata('success', 'Enabled Successfully.');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}



	//forget password functions start

	public function forget_password($page = 'forget-password')
	{
		$data['title'] = 'Forget password';
		$this->load->view('templates/header');
		$this->load->view('users/forget-password', $data);
		$this->load->view('templates/footer');
	}


		public function forget_password_mail()
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');

			//check if email is in the database
			$this->load->model('Administrator_Model');
			if($this->Administrator_Model->email_exists()){
			$email = $this->input->post('email');
			$temp_pass = md5(uniqid());

			if($this->Administrator_Model->set_temp_password($email, $temp_pass)) {
				
				$message = "<p>This email has been sent as a request to reset our password</p>";
				$message .= "<p><a href='".base_url()."users/reset-password/$temp_pass'>Click here </a>if you want to reset your password, if not, then ignore</p>";
				
				// sending email 

				$mailData = [
					'toEmail' => $this->input->post('email'),
					'subject' => 'Reset your Password',
					'message' => $message
				];
				

				if($this->sendMail($mailData)){
					$this->load->model('Administrator_Model');
					$this->session->set_flashdata('message', 'check your email for instructions.');
					redirect('users/login');
				}
				else
				{
					echo "email was not sent, please contact your administrator";
				}
			}
			else 
			{
				echo "please try again later.";
			}

			} 
			else
			{
				$this->session->set_flashdata('message',"Your email is not in our database");
				redirect('users/forget-password');
			}
		}

		public function reset_password($temp_pass){
			
			$this->load->model('Administrator_Model');
			
			$data['temp_pass'] = $temp_pass;
			$this->load->view('users/reset-password', $data);

		}

		public function update_password()
		{
			$this->load->model('Administrator_Model');

			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('temp_pass', 'Key', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');

			$temp_pass = $this->input->post('temp_pass');
			$newpassword = $this->input->post('password');

			if($this->form_validation->run())
			{
				
				if(!$this->Administrator_Model->is_temp_pass_valid($temp_pass))
				{
					$this->session->set_flashdata('message', 'Invalid key passed');
					redirect('users/reset-password/'.$temp_pass);
				}
				else 
				{
					$this->Administrator_Model->temp_reset_password($temp_pass, $newpassword);
					redirect('users');
				}
			}
			else
			{ 	
				$data['temp_pass'] = $temp_pass;
				$this->load->view('users/reset-password', $data);
			}
		}


	function sendMail($mailData)
	{
		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'satish.purohit.3@gmail.com', // change it to yours
		  'smtp_pass' => 'satish@0112', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('satish.purohit.3@gmail.com'); // change it to yours
		$this->email->to($mailData['toEmail']);// change it to yours
		$this->email->subject($mailData['subject']);
		$this->email->message($mailData['message']);
		if($this->email->send())
		{
			return true;
		}
		else
		{
			show_error($this->email->print_debugger());
			return false;
		}

	}
			

}