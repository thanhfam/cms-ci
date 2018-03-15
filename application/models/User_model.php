<?php

class User_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save_password(&$item) {
		if (empty($item['id'])) {
			return FALSE;
		}

		if (isset($item['updated'])) {
			$updated = $item['updated'];
		}

		$item['updated'] = get_time();

		$this->db->where('id', $item['id']);

		$result = $this->db->update('user', array(
			'password_plain' => $item['password_new'],
			'password' => $this->hash_password($item['password_new'])
		));

		if ($result) {
			$message = array(
				'type' => 1,
				'content' => $this->lang->line('update_success')
			);

			$item['updated'] = date_string();
		}
		else {
			$message = array(
				'type' => 3,
				'content' => $this->lang->line('db_update_danger')
			);

			if (isset($updated)) {
				$item['updated'] = $updated;
			}
		}

		return $message;
	}

	public function change_password(&$item) {
		if (empty($item['id'])) {
			return FALSE;
		}

		$this->db
			->select('u.id')
			->from('user u')
			->where('u.id', $item['id'])
			->where('u.password', $this->hash_password($item['password']))
		;

		$this->load->helper(array('language'));

		if ($result = $this->db->get()->row_array()) {
			$message = $this->save_password($item);
		}
		else {
			$message = array(
				'type' => 3,
				'content' => $this->lang->line('password_incorrect')
			);
		}

		return $message;
	}

	public function save(&$item) {
		if (isset($item['avatar_id']) && !empty($item['avatar_id'])) {
			$avatar_id = $item['avatar_id'];

			if (gettype($avatar_id) == 'array') {
				$item['avatar_id'] = $avatar_id[0];
			}
		}
		else {
			$item['avatar_id'] = 0;
		}

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('user', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('user', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		return $result;
	}

	public function hash_password($password) {
		return md5($password . SECRET_KEY . $password);
	}

	public function generate_password() {
		$seeds = 'abcdefghklmnpqrstuvx123456789';
		$password = array(); 
		$alpha_length = strlen($seeds) - 1; 

		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alpha_length);
			$password[] = $seeds[$n];
		}
		return implode($password);
	}

	public function login($item) {
		$this->db
			->select('u.id')
			->from('user u')
			->where('u.username', $item['username'])
			->where('u.password', $this->hash_password($item['password']))
		;

		if ($item = $this->db->get()->row_array()) {
			$user = $this->get($item['id']);

			return $user;
		}
		else {
			return FALSE;
		}
	}

	public function remove($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->where('id', $id)
			->delete('user');

		$result = $this->db->affected_rows();

		return $result;
	}

	public function get_menu_data($user) {
		$this->db
			->select('r.name')
			->from('user_group ug')
			->join('user_group_right ugr', 'ug.id = ugr.user_group_id')
			->join('right r', 'r.id = ugr.right_id')
			->where('ug.id', $user['user_group_id'])
		;

		$item = $this->db->get()->result_array();

		if ($item) {
			$menu_data = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($item)), 0);
		}

		return implode('___', $menu_data);
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$this->load->model(array('media_model'));

		$id = intval($id);

		$this->db
			->select('u.id, u.username, u.name, u.email, u.phone, u.timezone, u.date_format, u.user_group_id, u.state_weight, u.site_id, u.last_login, u.created, u.updated, u.avatar_id, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('user u')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->where('u.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			if ($item['last_login']) {
				$item['last_login'] = date_string($item['last_login']);
			}

			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			if ($item['avatar_file_name']) {
				$url = $this->media_model->get_url(array(
					'file_ext' => $item['avatar_file_ext'],
					'type' => $item['avatar_type'],
					'folder' => $item['avatar_folder'],
					'file_name' => $item['avatar_file_name']
				));

				$item['avatar_url'] = $url['tmb'];
				$item['avatar_url_opt'] = $url['opt'];
				$item['avatar_url_ori'] = $url['ori'];
			}
			else {
				$item['avatar_url'] = $item['avatar_url_opt'] = $item['avatar_url_ori'] = '';
			}
		}

		return $item;
	}

	public function list_simple($category_id = 0) {
		$this->db
			->select('id, username, concat(username, " (", id, ")") title')
			->order_by('username', 'ASC')
		;

		if ($category_id) {
			$this->db->where('category_id', $category_id);
		}

		return $this->db->get('user')->result_array();
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('u.id, u.username, u.email, u.phone, u.state_weight, s.name state_name, u.last_login, u.user_group_id, ug.title user_group_title, u.created, u.updated')
			->from('user u')
			->join('state s', 'u.state_weight = s.weight')
			->join('user_group ug', 'u.user_group_id = ug.id')
			->where('s.type', ST_USER)
			->order_by('u.state_weight', 'DESC')
			->order_by('u.username', 'ASC')
		;

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(u.id)', $filter)
				->or_like('LOWER(u.username)', $filter)
				->or_like('LOWER(u.email)', $filter)
				->or_like('LOWER(ug.title)', $filter)
				->group_end()
			;
		}

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = ceil($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($row = $query->unbuffered_row('array')) {
			$row['updated'] = date_string($row['updated']);
			$row['created'] = date_string($row['created']);
			$list[] = $row;
		}

		//echo $this->db->last_query();

		return $list;
	}
}
