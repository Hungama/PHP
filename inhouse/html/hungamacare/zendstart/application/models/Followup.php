<?php
class Application_Model_Followup
{
    protected $_id;
	protected $_UserName;
    protected $_Password;
    protected $_name;
	protected $_added_on;
	protected $_db_access;
	
	/*
	public function __construct(array $options = null)
    {
		if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Followme1 property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Followme property');
        }
        return $this->$method();
    }
	
	public function setOptions(array $options)
    {
		$methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
	*/

	public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }

    public function setUserName($login)
    {
		$this->_UserName = (string) $login;
        return $this;
    }
 
    public function getUserName()
    {
		return $this->_UserName;
    }
 
    public function setPassword($pwd)
    {
        $this->_pwd = (string) $pwd;
        return $this;
    }
 
    public function getPassword()
    {
        return $this->_Password;
    }

	public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
 
    public function getName()
    {
        return $this->_name;
    }
 
    public function setAddedOn($addedOn)
    {
        $this->_added_on = $addedOn;
        return $this;
    }
 
    public function getAddedOn()
    {
        return $this->_added_on;
    }

	public function setDbAccess($DbAccess)
    {
        $this->_db_access = $DbAccess;
        return $this;
    }
 
    public function getDbAccess()
    {
        return $this->_db_access;
    }
}
?>