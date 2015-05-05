<?php
class User
{
    private $username;
	private $connected;
	private $email;
    public function __construct($username = '', $connected = false, $email = '')
	{
		$this->username = $username;
		$this->connected = $connected;
		$this->email = $email;
	}
	public function setUsername($username)
	{
		$this->username = $username;
	}
	public function setConnected($connected)
	{
		$this->connected = $connected;
	}
	public function isConnected()
	{
		return $this->connected;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		return $this->email = $email;
	}
}
?>











