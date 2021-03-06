<?php 
	class Administrator extends CI_Controller
	{

		public function view($page = 'index'){
			if($this->session->userdata('login')) {
				redirect('administrator/models');
			}

			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			//$this->load->view('administrator/header');
			//$this->load->view('administrator/index');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function home($page = 'home'){
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function dashboard($page = 'dashboard'){
		   if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		   }
		   $data['title'] = ucfirst($page);
		   $this->load->view('administrator/header-script');
		   $this->load->view('administrator/header');
		   $this->load->view('administrator/header-bottom');
		   $this->load->view('administrator/'.$page, $data);
		   $this->load->view('administrator/footer');
		}

	 

	  // Log in Admin
		public function adminLogin(){
			$data['title'] = 'Admin Login';

			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				//$data['title'] = ucfirst($page);
				$this->load->view('administrator/header-script');
				//$this->load->view('administrator/header');
				//$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/index', $data);
				$this->load->view('administrator/footer');
			}else{
				// get email and Encrypt Password
				$email = $this->input->post('email');
				$encrypt_password = md5($this->input->post('password'));

				$user_id = $this->Administrator_Model->adminLogin($email, $encrypt_password);
				$sitelogo = $this->Administrator_Model->update_siteconfiguration(1);

				if ($user_id && $user_id->role_id == 1) {
					//Create Session
					$user_data = array(
								'user_id' => $user_id->id,
								'username' => $user_id->username,
								'email' => $user_id->email,
								'login' => true,
								'role' => $user_id->role_id,
								'image' => $user_id->image,
								'site_logo' => $sitelogo['logo_img']
					);

					$this->session->set_userdata($user_data);

					//Set Message
					$this->session->set_flashdata('success', 'Welcome to administrator Dashboard.');
					redirect('administrator/models');
				}else{
					$this->session->set_flashdata('danger', 'Login Credential in invalid!');
					redirect('administrator/index');
				}
				
			}
		}

				// log admin out
		public function logout(){
			// unset user data
			$this->session->unset_userdata('login');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('role_id');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('image');
			$this->session->unset_userdata('site_logo');

			//Set Message
			$this->session->set_flashdata('success', 'You are logged out.');
			redirect(base_url().'administrator/index');
		}

		public function forget_password($page = 'forget-password'){
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			//$this->load->view('administrator/header');
			//$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function add_user($page = 'add-user')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Create User';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');
			// $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
				 $this->load->view('administrator/header');
				 $this->load->view('administrator/header-bottom');
				 $this->load->view('administrator/'.$page, $data);
				 $this->load->view('administrator/footer');
			}else{
				$password = md5($this->input->post('password'));
				// $cpassword = md5($this->input->post('cpassword'));

				$this->Administrator_Model->add_user($password);
				
				
				/*
				$mailData = [
					'toEmail' => $this->input->post('email'),
					'subject' => 'Account Sctivation',
					'message' => "<a href='http://localhost/carshop/users/activate/$password'>Click here</a> to activate your account"
				];
				$this->sendMail($mailData);
				*/
				

				//Set Message
				$this->session->set_flashdata('success', 'User has been created Successfull.');
				redirect('administrator/users');
			}
			
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

		public function users($offset = 0)
		{
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/users/';
			$config['total_rows'] = $this->db->count_all('users');
			$config['per_page'] = 200;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'Latest Users';

			$data['users'] = $this->Administrator_Model->get_users(FALSE, $config['per_page'], $offset);

				$this->load->view('administrator/header-script');
				 $this->load->view('administrator/header');
				 $this->load->view('administrator/header-bottom');
				 $this->load->view('administrator/users', $data);
				$this->load->view('administrator/footer');
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

		public function update_user($id = NULL)
		{
			$data['user'] = $this->Administrator_Model->get_user($id);
			
			if (empty($data['user'])) {
				show_404();
			}
			$data['title'] = 'Update User';

			$this->load->view('administrator/header-script');
			 $this->load->view('administrator/header');
			 $this->load->view('administrator/header-bottom');
			 $this->load->view('administrator/update-user', $data);
			$this->load->view('administrator/footer');
		}

		public function update_user_data($page = 'update-user')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Update User';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
				 $this->load->view('administrator/header');
				 $this->load->view('administrator/header-bottom');
				 $this->load->view('administrator/'.$page, $data);
				 $this->load->view('administrator/footer');
			}else{
				//Upload Image
				
				$config['upload_path'] = './assets/images/users';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$id = $this->input->post('id');
					$data['img'] = $this->Administrator_Model->get_user($id);
					$errors =  array('error' => $this->upload->display_errors());
					$post_image = $data['img']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_user_data($post_image);

				//Set Message
				$this->session->set_flashdata('success', 'User has been Updated Successfull.');
				redirect('administrator/users');
			}
			
		}


		public function get_admin_data()
		{
			$data['changePassword'] = $this->Administrator_Model->get_admin_data();
			$data['title'] = 'Change Password';

			$this->load->view('administrator/header-script');
			 $this->load->view('administrator/header');
			 $this->load->view('administrator/header-bottom');
			 $this->load->view('administrator/change-password', $data);
			$this->load->view('administrator/footer');
		}

		public function change_password($page = 'change-password')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Change password';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_match_old_password');
			$this->form_validation->set_rules('new_password', 'New Password Field', 'required');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'matches[new_password]');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
				 $this->load->view('administrator/header');
				 $this->load->view('administrator/header-bottom');
				 $this->load->view('administrator/'.$page, $data);
				 $this->load->view('administrator/footer');
			}else{


				$this->Administrator_Model->change_password($this->input->post('new_password'));

				//Set Message
				$this->session->set_flashdata('success', 'Password Has Been Changed Successfull.');
				redirect('administrator/change-password');
			}
			
		}
		// Check user name exists
		public function match_old_password($old_password){
			
			$this->form_validation->set_message('match_old_password', 'Current Password Does not matched, Please Try Again.');
			$password = md5($old_password);
			$que = $this->Administrator_Model->match_old_password($password);
			if ($que) {
				return true; 
			}else{
				return false;
			}
		}

		public function update_admin_profile()
		{
			$data['user'] = $this->Administrator_Model->get_admin_data();
			$data['title'] = 'Update Profile';

			$this->load->view('administrator/header-script');
			 $this->load->view('administrator/header');
			 $this->load->view('administrator/header-bottom');
			 $this->load->view('administrator/update-profile', $data);
			$this->load->view('administrator/footer');
		}

		public function update_admin_profile_data($page = 'update-profile')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Update Profile';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
				 $this->load->view('administrator/header');
				 $this->load->view('administrator/header-bottom');
				 $this->load->view('administrator/'.$page, $data);
				 $this->load->view('administrator/footer');
			}else{
				//Upload Image
				
				$config['upload_path'] = './assets/images/users';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$id = $this->input->post('id');
					$data['img'] = $this->Administrator_Model->get_user($id);
					$errors =  array('error' => $this->upload->display_errors());
					$post_image = $data['img']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_user_data($post_image);

				//Set Message
				$this->session->set_flashdata('success', 'User has been Updated Successfull.');
				redirect('administrator/update-profile');
			}
			
		}


		//forget password functions start
	public function forget_password_mail()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');

		$this->load->model('Administrator_Model');

		if($this->Administrator_Model->email_exists())
		{
			$email = $this->input->post('email');
			$temp_pass = md5(uniqid());

			if($this->Administrator_Model->set_temp_password($email, $temp_pass)) 
			{
				
				$message = "<p>This email has been sent as a request to reset our password</p>";
				$message .= "<p><a href='".base_url()."administrator/reset-password/$temp_pass'>Click here </a>if you want to reset your password, if not, then ignore</p>";
				
				// sending email 

				$mailData = [
					'toEmail' => $this->input->post('email'),
					'subject' => 'Reset your Password',
					'message' => $message
				];
				

				if($this->sendMail($mailData)){
					$this->load->model('Administrator_Model');
					$this->session->set_flashdata('success', 'check your email for instructions.');
					redirect('administrator/index');
				}
				else
				{
					echo "email could not be sent, please contact your administrator";
				}
			}
			else 
			{
				echo "please try again later.";
			}

		} 
		else
		{
			$this->session->set_flashdata('message',"your email is not in our database");
			redirect('administrator/forget-password');
		}
}

public function reset_password($temp_pass){
	
	$this->load->model('Administrator_Model');
	
	$data['temp_pass'] = $temp_pass;
	$this->load->view('administrator/reset-password', $data);

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
			redirect('administrator/reset-password/'.$temp_pass);
		}
		else 
		{
			$this->Administrator_Model->temp_reset_password($temp_pass, $newpassword);
			redirect('administrator');
		}
	}
	else
	{ 	
		$data['temp_pass'] = $temp_pass;
		$this->load->view('administrator/reset-password', $data);
	}
}


	public function get_cars()
	{
		$data['products'] = $this->Administrator_Model->get_cars();
	
		$data['title'] = 'List Cars';

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/cars', $data);
		$this->load->view('administrator/footer');
	}

	public function update_cars($id)
	{
		
		$data['carData'] = $this->Administrator_Model->get_cars($id);

		$data['dealers'] = $this->Administrator_Model->getDropdown('dealers');
		$data['category'] = $this->Administrator_Model->getDropdown('category');
		
		if(empty($data['carData'])){
			$data['carData'] = array(
				'id' => 0,
				'title' => '',
				'dealer' => '',
				'category' => '',
				'url' => '',
				'date' => '',
				'image' => '',
				'blurb' => '',
				'status' => 1,
			);
		} 
		
		// Check login
		if(!$this->session->userdata('login')) {
			redirect('administrator/index');
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
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/update-car', $data);
			$this->load->view('administrator/footer');		
			
		}else{
			$update = array(
				'id' => $this->input->post('id'),
				'dealer' => $this->input->post('dealer'),
				'category' => $this->input->post('category'),
				'title' => $this->input->post('title'),
				'url' => $this->input->post('url'),
				'date' => $this->input->post('date'),
				'image' => $this->input->post('image'),
				'status' => $this->input->post('status'),
				'blurb' => $this->input->post('blurb'),
				'updated_by' => $loggedUser['user_id'],
				'updated_on' => date("Y-m-d H:i:s")
			);

			if($this->Administrator_Model->update_car($update)) {
				$this->session->set_flashdata('success', 'Model Saved Successfully.');
				redirect('administrator/models');	
			} else {
				$this->load->view('administrator/header-script');
				$this->load->view('administrator/header');
				$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/update-car', $data);
				$this->load->view('administrator/footer');		
			}

			
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

			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/csv-form');
			$this->load->view('administrator/footer');
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
				//echo str_replace(" ", "_", $_FILES['userfile']['name'] );exit;
			}
			
			$this->readCsv($config['upload_path'].'/'.$fileName);
			
			$this->session->set_flashdata('success', 'Data Updated Successfully.');
			redirect('administrator/models');
		}
	}

	function loadCarView() {
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/load-test-ajax');
		$this->load->view('administrator/footer');
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

	public function get_dealers() {

		$data['products'] = $this->Administrator_Model->get_dealers();
	
		$data['title'] = 'List Dealers';

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/dealers', $data);
		$this->load->view('administrator/footer');
	}


	public function update_dealers($id)
	{
		
		$data['carData'] = $this->Administrator_Model->get_dealers($id);

		if(empty($data['carData'])){
			$data['carData'] = array(
				'id' => 0,
				'name' => '',
				'code' => '',
				'status' => 1,
			);
		} 
		
		// Check login
		if(!$this->session->userdata('login')) {
			redirect('administrator/index');
		}
		$data['title'] = 'Update Dealer';

		$loggedUser = $this->session->userdata;

		$this->form_validation->set_rules('name', 'Dealer Name', 'required');
		$this->form_validation->set_rules('code', 'Dealer Code', 'required');
		
		if($this->form_validation->run() === FALSE) {
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/update-dealer', $data);
			$this->load->view('administrator/footer');		
			
		}else{
			$update = array(
				'id' => $this->input->post('id'),
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'status' => $this->input->post('status') ? 1 : 0
			);
			
			if($this->Administrator_Model->update_dealers($update)) {
				$this->session->set_flashdata('success', 'Dealer Saved Successfully.');
				redirect('administrator/dealers');	
			} else {
				$this->load->view('administrator/header-script');
				$this->load->view('administrator/header');
				$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/update-dealer', $data);
				$this->load->view('administrator/footer');		
			}

			
		}

	}


	public function get_category() {

		$data['products'] = $this->Administrator_Model->get_category();
	
		$data['title'] = 'List Category';

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/category', $data);
		$this->load->view('administrator/footer');
	}


	public function update_category($id)
	{
		
		$data['carData'] = $this->Administrator_Model->get_category($id);

		if(empty($data['carData'])){
			$data['carData'] = array(
				'id' => 0,
				'name' => '',
				'status' => 1,
			);
		} 
		
		// Check login
		if(!$this->session->userdata('login')) {
			redirect('administrator/index');
		}
		$data['title'] = 'Update Category';

		$loggedUser = $this->session->userdata;

		$this->form_validation->set_rules('name', 'Category Name', 'required');
		
		if($this->form_validation->run() === FALSE) {
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/update-category', $data);
			$this->load->view('administrator/footer');		
			
		}else{
			$update = array(
				'id' => $this->input->post('id'),
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status') ? 1 : 0
			);
			
			if($this->Administrator_Model->update_category($update)) {
				$this->session->set_flashdata('success', 'Category Saved Successfully.');
				redirect('administrator/category');	
			} else {
				$this->load->view('administrator/header-script');
				$this->load->view('administrator/header');
				$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/update-category', $data);
				$this->load->view('administrator/footer');		
			}

			
		}

	}


		
}
	




