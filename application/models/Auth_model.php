<?php

class Auth_model extends MY_Model {
	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');
	}

	public function require_right($right) {
		$this->db
			->select('u.id, u.username, u.name, u.email, u.user_group_id, u.state_weight, u.site_id, u.last_login, u.created, u.updated')
			->from('user u')
			->join('user_group ug', 'u.user_group_id = ug.id')
			->join('user_group_right ugr', 'ug.id = ugr.user_group_id')
			->join('right r', 'r.id = ugr.right_id')
			->where('u.id', $this->session->user['id'])
			->where('r.name', $right)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			return;
		}
		else {
			redirect(F_CP .'user/not_granted');
			exit(0);
		}
	}
}
