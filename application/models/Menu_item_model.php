<?php

class Menu_item_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$result = $this->db->insert('menu_item', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('menu_item', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function remove($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->where('id', $id)
			->delete('menu_item');

		$result = $this->db->affected_rows();

		return $result;
	}

	public function get($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->select('mt.id, mt.title, mt.url, mt.target, mt.menu_id, mt.menu_item_id, mt.position, mt.created, mt.updated')
			->from('menu_item mt')
			->where('mt.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function list_all($menu_id, $page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('mt.id, mt.title, mt.url, mt.target, mt2.id parent_id, mt2.title parent_title, m.id menu_id, m.name menu_name, mt.position, mt.created, mt.updated')
			->from('menu_item mt')
			->where('mt.menu_id', $menu_id)
			->join('menu_item mt2', 'mt.menu_item_id = mt2.id', 'left')
			->join('menu m', 'mt.menu_id = m.id')
			->order_by('mt.menu_item_id', 'ASC')
			->order_by('mt.position', 'ASC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(mt.id)', $filter)
				->or_like('LOWER(mt.title)', $filter)
			;
		}

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = floor($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		$result = $this->db->get()->result_array();

		//echo $this->db->last_query();

		return $result;
	}

	public function list_simple($menu_id, $menu_item_id = '') {
		$this->db
			->select('id, concat(title, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		if ($menu_id != '') {
			$this->db->where('menu_id', $menu_id);
		}

		if ($menu_item_id != '') {
			$this->db->where('id !=', $menu_item_id);
		}

		$result = $this->db->get('menu_item')->result_array();
		array_unshift($result, array(
			'id' => '',
			'title' => '-'
		));

		return $result;
	}

}