<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class MainProgram implements DbHandler
{
    private $_capsule;
    
    public function __construct()
    {
        $this->_capsule = new Capsule;
    }
    
    public function connect()
    {
        try 
        {
            $this->_capsule->addConnection([
                "driver" => database_type,
                "host" => host_name,
                "database" => database_name,
                "username" => user_name,
                "password" => user_password
            ]);
            $this->_capsule->setAsGlobal();
            $this->_capsule->bootEloquent();
            return true;
        } catch (\Exception $ex) {
            echo "Error : " . $ex->getMessage();
            return false;
        }
    }
    
    public function getData($fields = array(), $start = 0)
    {
        $items = Items::skip($start)->take(5)->get();
        if (empty($fields)) 
        {
            return $items;
        } else {
            $result = [];
            foreach ($items as $item) {
                $data = [];
                foreach ($fields as $field) {
                    $data[$field] = $item->$field;
                }
                $result[] = $data;
            }
            return $result;
        }
    }
    
    public function disconnect()
    {
        try 
        {
            Capsule::disconnect();
            return true;
        } catch (\Exception $e) {
            echo "Error : " . $e->getMessage();
            return false;
        }
    }
    
    public function getRecordById($id,$primary_key)
    {
        $item = Items::where($primary_key, "=", $id)->get();
        if (count($item) > 0)
            return $item[0];
    }
    
    public function searchByColumn($field, $value)
    {
        $items = Items::where($field, 'like', "%$value%")->get();

        if ($items->isNotEmpty()) {
            return $items;
        }
    }

    public function insertItem($formData)
    {
        try {
            $result = Items::insert($formData);
            // print_r($formData);

            if ($result) {
                echo "<h4>Data added successfully :)</h4>";
            } else {
                echo "Failed to add item";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function checkExistingID($id) 
    {
        $existingRecord = Items::where('id', $id)->first();
        return $existingRecord !== null;
    }


}
?>
