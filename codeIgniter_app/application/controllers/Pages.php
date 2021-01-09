<?php
class Pages extends CI_Controller {

    //viewメソッドの第二引数はviewに渡すデータを入れる
    public function view($page = 'home')
    {

        $this->load->database();
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

        // テーブルロックするとそのテーブルしか操作できなくなるので、採番テーブルをロックしながら、
        // 購入履歴テーブルをロックすることができない
        $this->db->trans_commit();
        $this->db->query('SET autocommit=0;');
        $this->db->query('lock tables sequence write;');
        $query = $this->db->get('sequence');
        $last_number = $query->row_array();
        $before_last_id= $last_number['id'];

        $after_last_id= $last_number['id'];
		foreach($purchase_infos as $purchase_info){
            $after_last_id++;
            $purchase_info['id'] = $after_last_id;
            $this->db->insert('purchase_log', $purchase_info);
		}
        $this->db->where('id', $before_last_id);
        $this->db->update('sequence',['id' => $after_last_id]);
        if ($this->db->trans_status() === FALSE){
            $this->db->query('rollback');
        }else{
            $this->db->query('commit');
        }
        $this->db->query('UNLOCK TABLES');


        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            // おっと、そのページはありません！
            show_404();
        }
        //view上の$titleを定義している
        $data['title'] = ucfirst($page); // 頭文字を大文字に

        //viewは表示順にロードしなければいけない
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}