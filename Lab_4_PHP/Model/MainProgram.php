<?php
require_once("vendor/autoload.php");
require_once("DbHandler.php");
require_once("Model/items.php");
require_once("config.php");

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
    
    public function searchByColumn($name_column, $value)
    {
        $items = Items::where($name_column, 'like', "%$value%")->get();
        if (count($items) > 0)
            return $items;
    }
}
?>
