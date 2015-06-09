<?php
class DatabaseManager
{
    private $db;
    
    
    public function __construct($login, $password, $databaseName)
	{
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
		$request = 'return db.texts.find({"id":"'.$textId.'"}, {"'.$language.'":1}).toArray()';
        $text = $this->db->execute($request)['retval'][0][$language];
        if(!$text)
        {
		    $text = false;
		}
		return $text;
	}
	
	
	public function isUsernameAvailable($username)
	{
	    $request = 'return db.users.count({"username":"'.$username.'"})';
	    $result = $this->db->execute($request)['retval'];
	    $b = false;
	    if($result)
	        $b = false;
	    else if(!$result)
	        $b = true;
        return $b;
	}
	
	
	public function isEmailAvailable($email)
	{
	    $request = 'return db.users.count({"email":"'.$email.'"})';
	    $result = $this->db->execute($request)['retval'];
	    $b = false;
	    if($result)
	        $b = false;
	    else if(!$result)
	        $b = true;
        return $b;
	}
	
	
	public function addUser($registrationDate, $username, $email, $hash, $confirmationId)
	{
	    $request = 'return db.users.insert(
            {"registrationDate":"'.$registrationDate.'",
            "username":"'.$username.'",
            "email":"'.$email.'",
            "hash":"'.$hash.'",
            "confirmationId":"'.$confirmationId.'"})';
	    $result = $this->db->execute($request)['ok'];
	    $b = false;
	    if($result == 1)
	    {
	        $b = true;
	    }
	    return $b;
	}
	
	
	public function userMatchPassword($username, $password)
	{
	    $request = 'return db.users.find({"username":"'.$username.'"}, {"hash":1}).toArray();';
	    $result = $this->db->execute($request);
	    $hash = $result['retval'][0]['hash']; 
	    if(password_verify($password, $hash))
			return true;
		else
			return false;
	}
	
	
	public function getRealUsername($username)
	{
        $request = 'return db.users.find({"username":"'.$username.'"}, {"username":1}).toArray();';
        $result = $this->db->execute($request);
        $username = $result['retval'][0]['username'];
		return $username;
	}
	
	
	public function getEmail($username)
	{
	    $request = 'return db.users.find({"username":"'.$username.'"}, {"email":1}).toArray();';
        $result = $this->db->execute($request);
        $email = $result['retval'][0]['email'];
		return $email;
	}
	
	
	public function confirmEmail($confirmationId)
	{
	    $ok = true;
	    //
	    if($ok && !strlen($confirmationId))
	    {
	        $ok = false;
	    }
	    // Check confirmationId exists
	    if($ok)
	    {
	        $request = 'return db.users.count({"confirmationId":"'.$confirmationId.'"});';
	        $result = $this->db->execute($request);
	        $count = $result['retval'];
	        if($count != 1)
	        {
	            $ok = false;
	        }
	    }
	    //
	    if($ok)
	    {
	        $request = 'return db.users.update({"confirmationId":"'.$confirmationId.'"}, {$set:{"confirmed":true, "confirmationId":""}}, true);';
            $result = $this->db->execute($request);
            $ok = $result['ok'];
	    }
        return $ok;
	}
	
	
	public function isConfirmed($username)
	{
	    $ok = true;
	    $request = 'return db.users.count({"username":"'.$username.'", "confirmed":true});';
	    $result = $this->db->execute($request);
	    $count = $result['retval'];
	    if($count != 1)
	    {
	        $ok = false;
	    }
		return $ok;
	}
}
?>

