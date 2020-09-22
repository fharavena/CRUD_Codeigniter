<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudModel extends Model
{
    var $table = 'uf';

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $db = \Config\Database::connect();
        $builder = $db->table('uf');
    }

    public function get_all_uf()
    {
        $query = $this->db->query('select * from uf order by fecha desc');
        return $query->getResult();
    }

    public function get_by_id($id)
    {
        $sql = 'select * from uf where id =' . $id;
        $query =  $this->db->query($sql);
        return $query->getRow();
    }

    public function drop_basededatos()
    {
        $this->db->query('delete from uf where 1=1');
    }

    public function refill($apiresponse)
    {
        foreach ($apiresponse->serie as $elemento) {
            $data = [
                'valor' => $elemento->valor,
                'fecha' => substr($elemento->fecha, 0, 10)
            ];
            $this->uf_add($data);
        }
    }

    public function uf_add($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function uf_update($where, $data)
    {
        $this->db->table($this->table)->update($data, $where);
        return $this->db->affectedRows();
    }

    public function delete_by_id($id)
    {
        $this->db->table($this->table)->delete(array('id' => $id));
    }
}
