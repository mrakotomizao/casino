<?php

/**
 * Created by PhpStorm.
 * User: guizmo
 * Date: 10/01/2016
 * Time: 21:52
 */
class Utilisateur extends CI_Model
{
    private $tableName = 'utilisateurs';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function setUtilisateur($fbid, $nom, $prenom, $pseudo, $email, $newsletter = 0)
    {
        if (empty($newsletter)) {
            $newsletter = 0;
        }
        $data = [
            'id_util' => $fbid,
            'nom' => $nom,
            'prenom' => $prenom,
            'pseudo' => $pseudo,
            'email' => $email,
            'newsletter' => $newsletter,
        ];

        $result = $this->db->select('*')
            ->where('id_util', $fbid)
            ->get($this->tableName)
            ->result();

        if (empty($result[0])) {
            return $this->db->insert($this->tableName, $data);
        } else {
            return 0;
        }
    }

    public function getSpecificUser($fbId)
    {
        $result = $this->db->select('*')
            ->where('id_util', $fbId)
            ->get($this->tableName)
            ->result();
        var_dump($result);
    }
}