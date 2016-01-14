<?php

/**
 * Created by PhpStorm.
 * User: guizmo
 * Date: 10/01/2016
 * Time: 21:53
 */
class Action extends CI_Model
{
    private $tableName = 'actions';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function setAction($iduser, $value)
    {
        $data = [
            'valeur' => $value,
            'id_util' => $iduser
        ];

        $this->db->insert($this->tableName, $data);
    }

    public function getSumVal($id)
    {
        $val = $this->db->select_sum('valeur')
            ->where('id_util', $id)
            ->get($this->tableName)
            ->result();
        return $val;
    }

    public function getDailyAction($id)
    {
        /*$condition = [
            'id_util' => $id
        ];
        $condition_like = [
            'date::TEXT' =>date('Y-m-d')
        ];*/
        $query = "SELECT * FROM actions WHERE id_util = $id AND date::TEXT LIKE '%" . date('Y-m-d') . "%'";
        $request = $this->db->query($query)->num_rows();
        /*$request = $this->db->select('*')
            ->where($condition)
            ->like($condition_like)
            ->get($this->tableName)
            ->num_rows();*/

        return $request;
    }

    //FONCTION QUI RECUPERE EN BDD LE NOMBRE DE POINT DU JOUR
    public function getDailyPoint($id)
    {
/*        $condition = [
            'id_util' => $id,
        ];
        $condition_like = [
            'date' => date('Y-m-d')
        ];

        $daillySum = $this->db->select_sum('valeur')
            ->where($condition)
            ->like($condition_like)
            ->get($this->tableName)
            ->result();*/
        $query = "SELECT SUM(valeur) FROM actions WHERE id_util = $id AND date::TEXT LIKE '%" . date('Y-m-d') . "%'";
        $request = $this->db->query($query)->result();


        return $request;
    }
}