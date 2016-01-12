<?php

/**
 * Created by PhpStorm.
 * User: guizmo
 * Date: 10/01/2016
 * Time: 21:53
 */
class Rang extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function update_entry()
    {
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function getAll()
    {
        $qry_res = $this->db->get('rang');
        $res = $qry_res->result();

        $qry_res->free_result();

        return $res;
    }

}