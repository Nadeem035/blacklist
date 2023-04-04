<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
	        parent::__construct();
	        error_reporting(0);
	        $this->load->database();
	        $this->load->model('Model_functions','model');
	        $this->load->helper(array('form', 'url', 'cookie'));
	        $this->load->library('session', 'http');
	}

	public function template($page = '', $data = '')
	{
		if (isset($_SESSION['user']))
		{
			$data['user'] = unserialize($_SESSION['user']);
			$data['signin'] = true;
		}
		else
		{
			$data['signin'] = false;
		}
		$this->load->view('header',$data);
		$this->load->view($page,$data);
		$this->load->view('footer',$data);
	}
	public function login_template($page = '', $data = '')
	{
		if (isset($_SESSION['user']))
		{
			$data['user'] = unserialize($_SESSION['user']);
			$data['signin'] = true;
		}
		else
		{
			$data['signin'] = false;
		}
		$this->load->view('login_header',$data);
		$this->load->view($page,$data);
		$this->load->view('footer',$data);
	}
	/**
	*
	*	signin/logout process startRs from here
	*
	*/

	public function signin()
	{
		if (isset($_SESSION['user']))
		{
			redirect('index');
			return;
		}
		$data['title'] = 'signin';
		$this->login_template('signin', $data);
	}
	public function signup()
	{
		if (isset($_SESSION['user']))
		{
			redirect('index');
			return;
		}
		$data['title'] = 'signup';
		$this->login_template('signup', $data);
	}
	public function check_login()
	{
		if(isset($_SESSION['user']) && $_SESSION['user']!= "")
		{
			$user = unserialize($_SESSION['user']);
			$email = $user['email'];
			$password = $user['password'];
			$resp = $this->model->get_row("SELECT * FROM `user` WHERE `email` = '$email'  AND `password` =  '$password'");
			if ($resp)
			{
				return $user;
			}
			else
			{
				redirect('signin');
			}
		}
		else 
		{
			redirect('signin');
		}
	}
	public function change_password()
	{
		$user = $this->check_login();
		$data['signin'] = FALSE;
		$email = $user['email'];
		if (isset($_POST['password']) && strlen($_POST['password']) > 0 && isset($_POST['re_password']) && strlen($_POST['re_password']) > 0) 
		{
			$password = md5($_POST['password']);
			$re_password = md5($_POST['re_password']);
			if ($password === $re_password) 
			{
				if ($this->db->update('user', array("password"=>$password), array("email"=>$email))) 
				{
					redirect("logout");
				}
			}
			else
			{
				redirect("change_password?error=1&msg='Your Provided Passwords are not matched, please try with correct password'");
			}
		}
		$data['email'] = $email;
		$this->template("change_password", $data);
	}

	public function logout()
	{
		unset($_SESSION['user']);
		redirect("index");
	}
	/**
	@Login Ajax
	*/
	public function process_login()
	{
		$data = array();
		parse_str($_POST['data'],$data);
		$_POST = $data;
		if ($_POST)
		{
			$email = $_POST['email'];
			$password = md5($_POST['password']);

			$resp = $this->model->get_row("SELECT * FROM `user` WHERE `email` = '$email' AND `password` =  '$password';");

			if ($resp)
			{
				$_SESSION['user'] = serialize($resp);
				$html = '<div class="alert bg-success text-white alert-bg alert-rounded">Successfully Logged In</div>';
				echo json_encode(array('status' => true, 'html'=>$html));
				return;
			}
			else
			{
				$html = '<div class="alert bg-danger text-white alert-bg alert-rounded">Email Or Password not matched </div>';
				echo json_encode(array('status' => false, 'html'=>$html));
				return;
			}
		}
		else
		{
			$html = '<div class="alert bg-danger text-white alert-bg alert-rounded">Email Or Password not matched </div>';
				echo json_encode(array('status' => false, 'html'=>$html));
		}
	}
	public function process_signup()
	{
		$data = array();
		parse_str($_POST['data'],$data);
		$_POST = $data;
		if ($this->model->check_email($_POST['email'])) {
			$html = '<div class="alert bg-danger text-white alert-bg alert-rounded">User Already Exists </div>';
		 			echo json_encode(array('status' => false, 'html'=>$html));
			 		return;
			return;
		}else{
			$_POST['password'] = md5($_POST['password']);
		 	if ($this->db->insert('user', $_POST)) {
		 		$resp = $this->model->get_row("SELECT * FROM `user` WHERE `email` = '".$_POST['email']."' AND `password` =  '".$_POST['password']."';");
		 		if ($resp) {
			 		$_SESSION['user'] = serialize($resp);
			 		$html = '<div class="alert bg-success text-white alert-bg alert-rounded">Successfully Signed Up </div>';
		 			echo json_encode(array('status' => true, 'html'=>$html));
			 		return;
		 		}else{
		 			$html = '<div class="alert bg-danger text-white alert-bg alert-rounded">Something Went Wrong. </div>';
		 			echo json_encode(array('status' => false, 'html'=>$html));
		 		}
		 	}else{
		 		$html = '<div class="alert bg-danger text-white alert-bg alert-rounded">Something Went Wrong. </div>';
		 		echo json_encode(array('status' => false, 'html'=>$html));
		 	}
		}
	}


	public function post_photo_ajax()
	{
		$user = $this->check_login();
		if ($_FILES){
			$config['upload_path'] = 'uploads/';
        	$config['allowed_types'] = 'gif|jpeg|jpg|png|PNG|JPEG|JPG|GIF';
        	$config['encrypt_name'] = TRUE;
        	$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
			$new_name = md5(time().$_FILES['img']['name']).'.'.$ext;
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);
        	if ($this->upload->do_upload('img'))
        	{
	        	$img = $this->upload->data()['file_name'];
	        	echo json_encode(array("status"=>true,"data"=>$img));
        	}
        	else{
        		#error
	        	echo json_encode(array("status"=>false));
        	}

		}
		else{
			redirect('admin/logout');
		}
	}
	public function multiple_post_photo_ajax()
	{
		$user = $this->check_login();
		$images = array();
		foreach($_FILES["images"]["tmp_name"] as $key => $img) {

			$_FILES['file']['name']       = $_FILES['images']['name'][$key];
            $_FILES['file']['type']       = $_FILES['images']['type'][$key];
            $_FILES['file']['tmp_name']   = $_FILES['images']['tmp_name'][$key];
            $_FILES['file']['error']      = $_FILES['images']['error'][$key];
            $_FILES['file']['size']       = $_FILES['images']['size'][$key];

			$config['upload_path'] = 'uploads/';
	    	$config['allowed_types'] = 'jpg|png|jpeg|PNG|JPEG|JPG';
	    	$config['encrypt_name'] = TRUE;
	    	$ext = pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION);
			$new_name = md5(time().$_FILES["file"]['name']).'.'.$ext;
			$config['file_name'] = $new_name;
	    	$resp = $this->load->library('upload', $config);
	    	if ($resp) {
	        	$this->upload->do_upload('file');
				$images[$key] = $this->upload->data()['file_name'];
	    	}
		}
		echo json_encode(array("status"=> true, "images" =>$images ));
	}

	function saveCookie($ip){
		$cookie_value = $ip;
		$cookie_expiration = 2592000; // 30 days
		set_cookie('visiter_ip', $cookie_value, $cookie_expiration);
	}

	function get_ip_info()
	{
		$this->load->library('http');

		$ip_address = $_SERVER['REMOTE_ADDR'];
		// $ip_address = '182.185.132.44';
		// $ip_address = '182.122.123.23';
		// $ip_address = '182.122.123.11';
		// $this->saveCookie($ip_address);
		$cookie_value = get_cookie('visiter_ip');

		$ipinfo = array();

		if ($cookie_value !== $ip_address ){

			$response = $this->http->get('http://ip-api.com/json/' . $ip_address);
			$response = json_decode($response);
			// Check if the request was successful
			if ($response->status === "success") {
				if (isset($response->country)) {
					$country = $response->country;
					$url = 'https://restcountries.com/v2/name/' . urlencode($country) . '?fullText=true&fields=flag';
					$result = file_get_contents($url);
					$data = json_decode($result, true);
					$flag = $data[0]['flag'];

					$country = $this->db->get_where('visiters_country', array('country' => $country))->row_array();
					
					if ($country) {
						$country_id = $country['visiters_country_id'];
						$this->db->set('count_visiter', 'count_visiter+1', FALSE);
						$this->db->where('visiters_country_id', $country_id);
						$this->db->update('visiters_country');
					}else{
						$countryInfo = array(
							'country' => $response->country,
							'flag' => $flag,
							'count_visiter' => 1
						);
						$this->db->insert('visiters_country', $countryInfo);
					}
					
					$ip['ip_address'] = $ip_address;
					$ip['country'] = $response->country;
					$ip['country_code'] = $response->countryCode;
					$ip['flag'] = $flag;

					if($this->db->insert('visiters', $ip)){
						$this->saveCookie($ip_address);
					}	
				}
			}else{
				$ip['ip_address'] = $ip_address;
				if($this->db->insert('visiters', $ip)){
					$this->saveCookie($ip_address);
				}	
			}
		}

		$ipinfo['ipinfo'] = $this->db->get_where('visiters', array('ip_address' => $ip_address))->row_array();
		$ipinfo['countryInfo'] = $this->db->get_where('visiters_country', array('country' => $ipinfo['ipinfo']['country']))->row_array();

		return $ipinfo;
	}

	/*
	***************************
		WORKING STARTS HERE
	***************************
	*/
	public function index()
	{
		$data['title'] = 'BlackList';
		$data['ipinfo'] = $this->get_ip_info();
		$this->template('index', $data);
	}

	public function view_blacklist(){
		$user = $this->check_login();
		$data['title'] = 'BlackList';
		$data['record'] = $this->model->get_user_blacklist($user['user_id']);
		$this->template('view_blacklist', $data);
	}
	public function add_blacklist(){
		$user = $this->check_login();
		$data['title'] = 'Add BlackList Record';
		$this->template('add_blacklist', $data);
	}
	public function edit_blacklist()
	{
		$user = $this->check_login();
		$data['title'] = 'Update BlackList Record';
		$new_id = isset($_GET['id']) ? $_GET['id'] : 0;
		if($new_id < 1) 
		{
			echo ("Wrong Blacklist ID has been passed");
		}
		else 
		{
			$data['q'] = $this->model->get_blacklist_byid($new_id);
			$data['page_title'] = "Edit: BlackList";
			$data['mode'] = "edit";
			$this->template('add_blacklist', $data);
		}
	}
	public function post_blacklist()
	{
		$user = $this->check_login();
		$_POST['user_id'] = $user['user_id'];
		if ($this->db->insert('blacklist', $_POST)) {
			$id = $this->db->insert_id();
			$this->session->set_flashdata('msg', 'Record Added');
		}else{
			$this->session->set_flashdata('msg', 'Something Went Wrong');
		}
		redirect('view-blacklist');
	}
	public function update_blacklist()
	{
		$user = $this->check_login();
		$aid = $_POST['aid'];
		unset($_POST['aid'], $_POST['mode'], $_POST['security']);
		$this->db->where("blacklist_id",$aid);
		$data = $this->db->update("blacklist", $_POST);
		if($data)
		{
			$this->session->set_flashdata('msg', 'Updated Successfully');
		}else{
			$this->session->set_flashdata('msg', 'Something Went Wrong');
		}
		redirect('view-blacklist');
	}
	public function search_blacklist()
	{
		$data = array();
		parse_str($_POST['data'],$data);
		$_POST = $data;

		$result = $this->model->get_blacklist_record($_POST['search']);
		if ($result) {
	    	echo json_encode(array("status"=>true, "data"=>$result));
		}else{
	    	echo json_encode(array("status"=>false));
		}
	}
	public function delete_blacklist()
	{
		$user = $this->check_login();
		$this->db->where('blacklist_id', $_GET['id']);
		$resp = $this->db->delete('blacklist');
		if($resp)
		{
			$this->session->set_flashdata('msg', 'Record has Deleted');
		}else
		{
			$this->session->set_flashdata('msg', 'Record has failed to delete. Try Again');
		}
		redirect("view-blacklist");
	}
}
