<?php
include_once('./php/pages/page.php');

class LogInPage extends Page
{
	protected $previews;
	
	
    public function compute()
    {
        parent::compute();
		if($_SESSION['user']->isConnected())
			header('Location: '.Constants::$ROOT_URL.'/error/404');
		$this->checkForm();
    }
    
    
	public function checkForm()
	{
	    //
		$this->errors['username-empty'] = false;
		$this->errors['password-empty'] = false;
		$this->errors['connection-failed'] = false;
		$this->errors['not-confirmed'] = false;
		//
		$this->setText('username', '');
		if(isset($_POST['username'])
			&& isset($_POST['password']))
		{
			$this->setText('username', $_POST['username']);
			// Username
			if($_POST['username'] == '')
				$this->errors['username-empty'] = true;
			// Password
			if($_POST['password'] == '')
				$this->errors['password-empty'] = true;
			// Connection
			$ok = true;
			foreach($this->errors as $error)
			{
				if($error == true)
					$ok = false;
			}
			$username = $_POST['username'];
			$password = $_POST['password'];
			if($ok && !$this->databaseManager->userMatchPassword($username, $password))
			{
				$this->errors['connection-failed'] = true;
				$ok = false;
			}
			if($ok && !$this->databaseManager->isConfirmed($username))
			{
				$this->errors['not-confirmed'] = true;
				$ok = false;
			}
			// Confirmation
			if($ok)
			{
				$this->setText('username', '');
				$username = $this->databaseManager->getRealUsername($username);
				$email = $this->databaseManager->getEmail($username);
				$_SESSION['user']->setUsername($username);
				$_SESSION['user']->setEmail($email);
				$_SESSION['user']->setConnected(true);
				$_SESSION['just-log-in'] = true;
				header('Location: '.Constants::$ROOT_URL.'/home');
			}
		}
	}
	
	
	public function getMiddle()
	{
		$middle = '
		<section id="sign-in" class="main">
			<!--<h1>'.$this->getTextFromDatabase('log-in-h1').'</h1>-->
			<form id="register-form" action="" method="post" class="vertical">
				
				<h2 class="label left">'.$this->getTextFromDatabase('username').'</h2>
				<input id="username" name="username" class="input extend" value="'.$this->getText('username').'" placeholder="'.$this->getTextFromDatabase('username').'"/>
				'.$this->getError('username-empty').'
				
				
				<h2 class="label left">'.$this->getTextFromDatabase('password').'</h2>
				<input id="password" type="password" name="password" class="input extend" placeholder="'.$this->getTextFromDatabase('password').'"/>
				'.$this->getError('password-empty').'
				
				<input id="submit" name="submit" class="button extend" type="submit" value="'.$this->getTextFromDatabase('log-in').'" >
				'.$this->getError('connection-failed').'
				'.$this->getError('not-confirmed').'
				
			</form>
		</section>
		';
		return $middle;
	}
}
?>
