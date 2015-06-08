<?php
class DatabaseManager
{
    private $database;
    private $db;
    
    
    public function __construct($login, $password, $databaseName)
	{
	    // Mysql
        try
        {
			$this->database = new PDO("mysql:host=localhost;dbname=".$databaseName, $login, $password);
        }
        catch(Exception $e)
        {
			die('Error : '.$e->getMessage());
        }
        
        // Mongo
        $m = new MongoClient();
        $this->db = $m->ponyprediction;
	}
	
	
	public function getText($textId)
	{
		$language = '';
		if( $_SESSION['language'] == 'french')
		{
			$language = 'french';
		}
        $text = $this->db->execute('return db.texts.find({"id":"'.$textId.'"}, {"'.$language.'":1}).toArray()')['retval'][0][$language];
        if($text)
        {
		    return $text;
		}
		else
		{
			return false;
		}
	}
	
	
	public function isUsernameAvailable($username)
	{
		$request = $this->database->prepare("SELECT username FROM users WHERE username = :username");
		$request->bindParam(':username', $username);
		$request->execute();
		if($request->fetch())
			return false;
		else
			return true;
	}
	
	
	public function isEmailAvailable($email)
	{
		$request = $this->database->prepare("SELECT email FROM users WHERE email = :email");
		$request->bindParam(':email', $email);
		$request->execute();
		if($request->fetch())
			return false;
		else
			return true;
	}
	
	
	public function addUser($registrationDate, $username, $email, $hash, $confirmationId)
	{
		$request = $this->database->prepare("INSERT INTO users (registrationDate, username, email, hash, confirmationId) 
			VALUES (:registrationDate, :username, :email, :hash, :confirmationId);");
		$request->bindParam(':registrationDate', $registrationDate);
		$request->bindParam(':username', $username);
		$request->bindParam(':email', $email);
		$request->bindParam(':hash', $hash);
		$request->bindParam(':confirmationId', $confirmationId);
		return $request->execute();
	}
	
	
	public function userMatchPassword($username, $password)
	{
		$request = $this->database->prepare("SELECT hash FROM users WHERE username = :username;");
		$request->bindParam(':username', $username);
		$request->execute();
		$data = $request->fetch();
		$hash = $data['hash'];
		if(password_verify($password, $hash))
			return true;
		else
			return false;
	}
	
	
	public function getRealUsername($username)
	{
		$request = $this->database->prepare("SELECT username FROM users WHERE username = :username;");
		$request->bindParam(':username', $username);
		$request->execute();
		$data = $request->fetch();
		$username = $data['username'];
		return $username;
	}
	
	
	public function getEmail($username)
	{
		$request = $this->database->prepare("SELECT email FROM users WHERE username = :username;");
		$request->bindParam(':username', $username);
		$request->execute();
		$data = $request->fetch();
		return $data['email'];
	}
	
	
	public function confirmEmail($confirmationId)
	{
		$ok = true;
		$request = $this->database->prepare("SELECT confirmed FROM users WHERE confirmationId = :confirmationId;");
		$request->bindParam(':confirmationId', $confirmationId);
		$request->execute();
		$data = $request->fetch();
		if(!(isset($data['confirmed']) && $data['confirmed'] == false))
			$ok = false;
		if($ok)
		{
			$request = $this->database->prepare("UPDATE users SET confirmed = 1 WHERE confirmationId = :confirmationId;");
			$request->bindParam(':confirmationId', $confirmationId);
			$ok = $request->execute();
		}
		return $ok;
	}
	
	
	public function isConfirmed($username)
	{
	    $request = $this->database->prepare("SELECT confirmed FROM users WHERE username = :username;");
	    $request->bindParam(':username', $username);
		$request->execute();
		$data = $request->fetch();
		return $data['confirmed'];
	}
}
?>

