<?php
 
defined('C5_EXECUTE') or die("Access Denied.");
 
class StandardDbObject extends Object {

    private $_req_class_properties = array('error', '_req_class_properties');

    public function __call($name,$params)
    {
        $magic_functions = array('get', 'set', 'findBy', 'findOneBy');
            
        if(preg_match('/^(' . join($magic_functions, '|') . ')/', $name, $matches))
        {
            //1 is first match (0 is entire string matched)
            $function   = $matches[1];
            $property   = $this->uncamelcase(str_replace($function, '', $name));
            if(count($params))
                $input  = current($params);

        
            if(!array_key_exists($property, $this->_getDefaultProperties()))
                return false;

            if(isset($input))
            {
                return $this->$function($property, $input);
            }
            else
            {
                return $this->$function($property);
            }
        }
        return false;
    }

    public function __set($property, $value)
    {
        throw new Exception('Must use set methods');
    }
    public function __get($property)
    {
        throw new Exception('Must use get methods');
    }
        
    //returns an array of objects (collection)
    public function findWithQuery($query)
    {
        $res = $db->getAll($query);
        return $this->makeCollectionFromArray($res);
    }

    public function getId()
    {
        $pk = $this->_getPrimaryKey();

        if(is_null($this->$pk))
            throw new Exception("Entity must be saved first");

        return $this->$pk;
    }

    public function delete()
    {
        $pk = $this->_getPrimaryKey();
        $table = $this->_getTableName();

        $db = Loader::db();
        
        if(!is_null($this->$pk))
            $db->execute("DELETE FROM $table WHERE $pk = ?", array($this->$pk));

        //TODO:should ensure acutally deleted, or at least that no exception as thrown. 
        return true;
    }

    public function save()
    {
        $pk = $this->_getPrimaryKey();
        try{
            $id = $this->getId();
        }
        catch(Exception $e)
        {
            //do nothing we are saving.
        }
        $table = $this->_getTableName();

        if(is_null($id))
        {
            $this->insert();
        }
        else
        {
            //normally we would expect if the pkey is populated that there is a row in the db
            //  but we need to allow the user to specify if they aren't using auto_increment
            $db = Loader::db();
            $res = $db->getRow("SELECT * FROM $table WHERE $pk = ?", array($id));
            
            if(count($res))
            {
                $this->update();
            }
            else
            {
                $this->insert();
            }
        }

        return $this;
    }

    protected function _getPrimaryKey()
    {
        //feel free to override me
        return "id";
    }

    protected function _getTableName()
    {
        //way it should be
        //return $this->uncamelcase(str_replace('Object', '', get_class($this)));

        //way concrete does it
        return strtolower(str_replace('Object', '', get_class($this)));
    }

    protected function _getDefaultProperties()
    {
        $vars = get_class_vars(get_class($this));
        
        //error comes from base object (Concrete5_Library_Object)
        //  we might need to add more than just error
        foreach($this->_req_class_properties as $key)
            if(array_key_exists($key, $vars))
                unset($vars[$key]);

        return $vars;
    }

    private function checkForObjectReference($value)
    {
        if($value instanceof StandardDbObject)
            $value = $value->getId();
    
        if(is_object($value))
            throw new Exception("Not able to translate object to input parameter");

        return $value;
    }

    //returns an array of objects (collection)
    private function findBy($column, $value)
    {
        $db = Loader::db();
        $table = $this->_getTableName();

        $query =<<<SQL
            SELECT * 
            FROM $table
            WHERE $column = ?
SQL;

        //see if object try to find reference
        $value = $this->checkForObjectReference($value);

        $res = $db->getAll($query, array($value));

        return $this->makeCollectionFromArray($res);
    }

    //returns populated object
    private function findOneBy($column, $value)
    {
        $db = Loader::db();
        $table = $this->_getTableName();
        
        $query =<<<SQL
            SELECT * 
            FROM $table 
            WHERE $column = ?
SQL;

        //see if object try to find reference
        $value = $this->checkForObjectReference($value);

        $res = $db->getRow($query, array($value));

        if(count($res))
            return $this->makeThisFromArray($res);

        return null;
    }

    private function makeCollectionFromArray($array_of_getRow)
    {
        if(!count($array_of_getRow))
            return array();

        $count = 0;
        foreach($array_of_getRow as $row)
        {
            $arr_o[$count] = $this->makeThisFromArray($row);
            $count++;
        }

        return $arr_o;
    }

    private function makeThisFromArray($array)
    {
        $class = get_class($this);
        $o = new $class();
        $o->setPropertiesFromArray($array);

        return $o;
    }
        
    private function set($property, $value)
    {
        $this->$property = $value;
        return $this;
    }

    private function get($property)
    {
        return $this->$property;
    }

    private function update()
    {
        $pk = $this->_getPrimaryKey();
        $table = $this->_getTableName();

        $set = array();$vals = array();
        foreach($this->_getDefaultProperties() as $key => $default)
        {
            if($key == $pk)
                continue;

            $set[]  = $key . " = ?";
            $vals[] = $this->$key;
        }

        //value for primary key
        $vals[] = $this->$pk;

        $db = Loader::db();
        $db->execute("UPDATE $table SET " . join($set,',') . " WHERE $pk = ?", $vals);
    }

    private function insert()
    {
        $table = $this->_getTableName();
        $properties = $this->_getDefaultProperties();
        unset($properties[$this->_getPrimaryKey()]);

        $vals = array();
        $columns = array_keys($properties);
        foreach($columns as $property)
        {
            $vals[] = $this->$property;
        }

        $db = Loader::db();
        $db->execute("INSERT INTO $table (" . join($columns, ',') . ") 
                        VALUES (" . join(array_fill(0, count($columns), '?'), ',') . ")", $vals);

        $pk = $this->_getPrimaryKey();
        $this->$pk = $db->Insert_ID();
    }

}
