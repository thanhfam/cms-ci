<?php

class Image_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('image', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('image', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function get($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->select('i.id, i.name, p.content, p.created, p.updated')
			->from('image i')
			->where('i.id', $id)
		;

		$item = $this->db->get()->row_array();

		$item['created'] = date_string($item['created']);
		$item['updated'] = date_string($item['updated']);

		return $item;
	}
}
