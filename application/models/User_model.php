<?php

class User_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save_password(&$item) {
		if (empty($item['user_id'])) {
			return FALSE;
		}

		$this->db->where('user_id', $item['user_id']);
		$result = $this->db->update('user', array(
			'password' => $item['password_new']
		));

		$item['modified_at'] = $this->get_time();

		return $result;
	}

	public function save(&$item) {
		if (empty($item['user_id'])) {
			$result = $this->db->insert('user', $item);

			$item['user_id'] = $this->db->insert_id();
			$item['created_at'] = $item['modified_at'] = $this->get_time();
		}
		else {
			$this->db->where('user_id', $item['user_id']);
			$result = $this->db->update('user', $item);

			$item['created_at'] = $this->input->post('created');
			$item['modified_at'] = $this->get_time();
		}

		return $result;
	}

	public function hash_passwd($item) {
		return md5($item['username'] . $item['password'] . $item['password']);
	}

	public function check_login($item) {
		$this->db
			->select('u.user_id')
			->from('user u')
			->where('u.username', $item['username'])
			->where('u.passwd', $this->hash_passwd($item))
		;

		$item = $this->db->get()->row_array();

		print_r($item);

		return FALSE;
	}

	public function get($id = 0) {
		if ($id == 0) {
			return FALSE;
		}

		$this->db
			->select('u.user_id, u.username, u.email, u.auth_level, u.last_login, u.created_at, u.modified_at')
			->from('user u')
			->where('u.user_id', $id)
		;

		$item = $this->db->get()->row_array();

		$item['last_login'] = $this->get_time($item['last_login']);
		$item['created_at'] = $this->get_time($item['created_at']);
		$item['modified_at'] = $this->get_time($item['modified_at']);

		return $item;
	}

	public function list_simple($category_id = 0) {
		$this->db
			->select('user_id, username')
			->order_by('user_id', 'ASC')
		;

		if ($category_id) {
			$this->db->where('category_id', $category_id);
		}

		return $this->db->get('user')->result_array();
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('u.user_id, u.username, u.email, u.auth_level')
			->from('user u')
		;

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = floor($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		//echo $this->db->last_query();

		return $this->db->get()->result_array();
	}
}
