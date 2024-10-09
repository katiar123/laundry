<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'test123';
    private $dbname = 'laundry';
    protected $connect;


    public function __construct()
    {
        $this->connect = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->connect->connect_error) {
            die("Koneksi gagal: " . $this->connect->connect_error);
        }
    }

    private function getParamType($param)
    {
        if (is_int($param)) {
            return 'i';
        } elseif (is_double($param) || is_float($param)) {
            return 'd';
        } elseif (is_string($param)) {
            return 's'; 
        } elseif (is_bool($param)) {
            return 'b';
        }
        return null; 
    }

    public function insert($table, $columns = [], $params = [])
    {
        if (empty($table) || empty($columns) || empty($params) || count($columns) != count($params)) {
            return "Insert bermasalah. Pastikan data dan jumlah kolom serta parameter sesuai.";
        }

        $columns_string = implode(',', $columns);
        $placeholders = implode(',', array_fill(0, count($params), '?'));

        $type = '';
        foreach ($params as $param) {
            $type .= $this->getParamType($param);
        }

        $sql = "INSERT INTO $table ($columns_string) VALUES ($placeholders)";

        $stmt = $this->connect->prepare($sql);
        if ($stmt === false) {
            return "Gagal mempersiapkan statement: " . $this->connect->error;
        }

        $stmt->bind_param($type, ...$params);

        if ($stmt->execute()) {
            return "success";
        } else {
            return "Gagal menambahkan data: " . $stmt->error;
        }
    }

    public function all($table)
    {
        $data = [];
        $sql = "SELECT * FROM $table";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function delete($table, $columns, $params)
    {
        $type = $this->getParamType($params);

        if ($type === null) {
            return "Tipe data tidak dikenali.";
        }

        $sql = "DELETE FROM $table WHERE md5($columns) = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param($type, $params);
        if ($stmt->execute()) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function find($table, $column, $param)
    {
        $type = $this->getParamType($param);

        if ($type === null) {
            return "Tipe data tidak dikenali.";
        }

        if ($column === "id" || $column === "id_outlet" || $column === "id_transaksi") {
            $sql = "SELECT * FROM $table WHERE md5($column) = ?";
        } else {
            $sql = "SELECT * FROM $table WHERE $column = ?";
        }

        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param($type, $param);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    }


    public function put($table, $column, $field, $params, $value)
    {
        $type = '';
        $values = [];

        // Tentukan tipe untuk params
        foreach ($params as $param) {
            $type .= $this->getParamType($param);
            $values[] = $param;
        }

        // Tentukan tipe untuk value
        $type .= $this->getParamType($value);
        $values[] = $value;

        // Buat string untuk kolom yang akan diupdate
        $string = [];
        foreach ($column as $columns) {
            $string[] = $columns . ' = ?';
        }
        $setColumns = implode(',', $string);

        // Siapkan dan eksekusi query
        $sql = "UPDATE $table SET $setColumns WHERE $field = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param($type, ...$values);

        if ($stmt->execute()) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function getLastInsertId()
    {
        return $this->connect->insert_id;
    }

}
