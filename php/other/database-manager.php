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
		$scope = array("textId" => (string)$textId);
		$request = 'return db.texts.find({"id":textId}).toArray();';
        $result = $this->db->execute(new MongoCode($request, $scope));
        $text = $result['retval'][0][$_SESSION['language']];
        if(!$text)
        {
		    $text = false;
		}
		return $text;
	}
	
	
	public function isUsernameAvailable($username)
	{
	    $scope = array("username" => (string)$username);
	    $request = 'return db.users.count({"username":username});';
	    $result = $this->db->execute(new MongoCode($request, $scope));
	    $ok = $result['retval'];
	    $b = false;
	    if($ok)
	        $b = false;
	    else if(!$ok)
	        $b = true;
        return $b;
	}
	
	
	public function isEmailAvailable($email)
	{
	    $scope = array("email" => (string)$email);
	    $request = 'return db.users.count({"email":email})';
	    $result = $this->db->execute(new MongoCode($request, $scope));
	    $r = $result['retval'];
	    $b = false;
	    if($r)
	        $b = false;
	    else if(!$r)
	        $b = true;
        return $b;
	}
	
	
	public function addUser($registrationDate, $username, $email, $hash, $confirmationId)
	{
	    $scope = array("registrationDate" => (string)$registrationDate,
	        "username" => (string)$username,
	        "email" => (string)$email,
	        "hash" => (string)$hash,
	        "confirmationId" => (string)$confirmationId);
	    $request = 'return db.users.insert(
            {"registrationDate":registrationDate,
            "username":username,
            "email":email,
            "hash":hash,
            "confirmationId":confirmationId})';
        $result = $this->db->execute(new MongoCode($request, $scope));
	    $ok = $result['ok'];
	    $b = false;
	    if($ok == 1)
	    {
	        $b = true;
	    }
	    return $b;
	}
	
	
	public function userMatchPassword($username, $password)
	{
	    $scope = array("username" => (string)$username);
	    $request = 'return db.users.find({"username":username}, {"hash":1}).toArray();';
	    $result = $this->db->execute(new MongoCode($request, $scope));
	    $hash = $result['retval'][0]['hash'];
	    if(password_verify($password, $hash))
			return true;
		else
			return false;
	}
	
	
	public function getRealUsername($username)
	{
	    $scope = array("username" => (string)$username);
        $request = 'return db.users.find({"username":username}, {"username":1}).toArray();';
	    $result = $this->db->execute(new MongoCode($request, $scope));
        $username = $result['retval'][0]['username'];
		return $username;
	}
	
	
	public function getEmail($username)
	{
	    $scope = array("username" => (string)$username);
	    $request = 'return db.users.find({"username":username}, {"email":1}).toArray();';
	    $result = $this->db->execute(new MongoCode($request, $scope));
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
	        $scope = array("confirmationId" => (string)$confirmationId);
	        $request = 'return db.users.count({"confirmationId":confirmationId});';
	        $result = $this->db->execute(new MongoCode($request, $scope));
	        $count = $result['retval'];
	        if($count != 1)
	        {
	            $ok = false;
	        }
	    }
	    //
	    if($ok)
	    {
	        $scope = array("confirmationId" => (string)$confirmationId);
	        $request = 'return db.users.update({"confirmationId":confirmationId}, 
	            {$set:{"confirmed":true, "confirmationId":""}}, true);';
	        $result = $this->db->execute(new MongoCode($request, $scope));
            $ok = $result['ok'];
	    }
        return $ok;
	}
	
	
	public function isConfirmed($username)
	{
	    $ok = true;
	    $scope = array("username" => (string)$username);
	    $request = 'return db.users.count({"username":username, "confirmed":true});';
	        $result = $this->db->execute(new MongoCode($request, $scope));
	    $count = $result['retval'];
	    if($count != 1)
	    {
	        $ok = false;
	    }
		return $ok;
	}
}
?>

