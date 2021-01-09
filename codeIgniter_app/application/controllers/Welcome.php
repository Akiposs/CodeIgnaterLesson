<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$purchase_infos =[
			0 => [
				'name' => 'サランラップ',
				'money' => 3500,
			],
			1 => [
				'name' => 'サランラップ2',
				'money' => 8200,
			],
		];

		$this->db->query('lock table sequence write');
		$this->db->trans_start();
		foreach($purchase_infos as $purchase_info){
			$this->db->reset_query();
			$query = $this->db->get('secuence');
			$last_number = $query->row_array();

			$this->db->reset_query();
			$purchase_info['id'] = $last_number;
			$this->db->insert('purchase_log', $purchase_info);

			$this->db->reset_query();
			$this->db->where('id', 2);
			$this->db->update('sequence',['id' => ($last_number + 1)]);
		}
		$this->db->trans_complete();
		$this->db->query('unlock table sequence');

		$this->load->view('welcome_message');
	}
}
