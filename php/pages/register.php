<?php
include_once('./php/pages/page.php');

class RegisterPage extends Page
{
    public function compute()
    {
        parent::compute();
		$this->checkForm();
		$this->addJavascript('new RegisterManager();');
    }
	public function checkForm()
	{
		$this->errors['username-empty'] = false;
		$this->errors['username-unavailable'] = false;
		$this->errors['email-1-empty'] = false;
		$this->errors['email-1-invalid'] = false;
		$this->errors['email-2-empty'] = false;
		$this->errors['email-2-invalid'] = false;
		$this->errors['email-different'] = false;
		$this->errors['email-unavailable'] = false;
		$this->errors['password-1-empty'] = false;
		$this->errors['password-2-empty'] = false;
		$this->errors['password-different'] = false;
		$this->errors['registration-failed'] = false;
		$this->errors['send-email-failed'] = false;
		$this->success['registration-successful'] = false;
		$this->setText('username', '');
		$this->setText('email-1', '');
		$this->setText('email-2', '');
		if(isset($_POST['username'])
			&& isset($_POST['email-1'])
			&& isset($_POST['email-2'])
			&& isset($_POST['password-1'])
			&& isset($_POST['password-2']))
		{
			$this->setText('username', $_POST['username']);
			$this->setText('email-1', $_POST['email-1']);
			$this->setText('email-2', $_POST['email-2']);
			// Username
			if($_POST['username'] == '')
				$this->errors['username-empty'] = true;
			if(!$this->databaseManager->isUsernameAvailable($_POST['username']))
				$this->errors['username-unavailable'] = true;
			// Email
			$regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^";
			if($_POST['email-1'] == '')
				$this->errors['email-1-empty'] = true;
			if (!preg_match($regex, $_POST['email-1']))
				$this->errors['email-1-invalid'] = true;
			if($_POST['email-2'] == '')
				$this->errors['email-2-empty'] = true;
			if (!preg_match($regex, $_POST['email-2']))
				$this->errors['email-2-invalid'] = true;
			if($_POST['email-1'] != $_POST['email-2'])
				$this->errors['email-different'] = true;
			if(!$this->databaseManager->isEmailAvailable($_POST['email-1']))
				$this->errors['email-unavailable'] = true;
			// Password
			if($_POST['password-1'] == '')
				$this->errors['password-1-empty'] = true;
			if($_POST['password-2'] == '')
				$this->errors['password-2-empty'] = true;
			if($_POST['password-1'] != $_POST['password-2'])
				$this->errors['password-different'] = true;
			// Registration
			$ok = true;
			foreach($this->errors as $error)
			{
				if($error == true)
					$ok = false;
			}
			$username = $_POST['username'];
			$email = $_POST['email-1'];
			$hash = password_hash($_POST['password-1'], PASSWORD_DEFAULT);
			$registrationDate = (new DateTime("UTC"))->format('Y-m-d H:i:s');
			$confirmationId = bin2hex(password_hash($username.$email.$registrationDate, PASSWORD_DEFAULT));
			if($ok && !$this->databaseManager->addUser($registrationDate, $username, $email, $hash, $confirmationId))
			{
				$this->errors['registration-failed'] = true;
				$ok = false;
			}
			// Confirmation
			if($ok)
			{
				// Send mail
				$urlEmail  = Constants::$ROOT_URL . '/confirmation/' . $confirmationId;
				$urlAccount = Constants::$ROOT_URL . '/log-in';
				$to      = $email;
				$subject = $this->databaseManager->getText('email-confirmation-subject');//'PonyPrediction : account validation';
				$subject = wordwrap($subject, 70, "\r\n");
				$message = $this->databaseManager->getText('email-confirmation-message');
				$message = str_replace('USERNAME', $username, $message);
				$message = str_replace('URLACCOUNT', $urlAccount, $message);
				$message = str_replace('URLEMAIL', $urlEmail, $message);
				$message = wordwrap($message, 70, "\r\n");
				$headers = 'From: noreply@' . Constants::$DOMAIN . "\r\n";
				if(!mail($to, $subject, $message, $headers))
				{
					$this->errors['send-email-failed'] = true;
					$ok = false;
					// $remove user maybe ?
				}
			}
			if($ok)
			{
				$this->success['registration-successful'] = true;
				$this->setText('username', '');
				$this->setText('email-1', '');
				$this->setText('email-2', '');
			}
		}
	}
	public function getMiddle()
	{
		$middle = '
		<section id="register" class="main">
		
			<!--<h1>
				'.$this->getTextFromDatabase('register-h1').'
			</h1>
			<p>
				'.$this->getTextFromDatabase('register-p-0').'
			</p>-->
			
			<form id="register-form" action="" method="post" class="vertical">
			
				<h2 class="label left">'.$this->getTextFromDatabase('username').'</h2>
				<input id="username" name="username" class="input extend" value="'.$this->getText('username').'" placeholder="'.$this->getTextFromDatabase('username').'"/>
				'.$this->getError('username-empty').'
				'.$this->getError('username-unavailable').'
				
				<h2 class="label left">'.$this->getTextFromDatabase('email').'</h2>
				<input id="email-1" name="email-1" class="input extend" value="'.$this->getText('email-1').'" placeholder="'.$this->getTextFromDatabase('email').'"/>
				'.$this->getError('email-1-empty').'
				'.$this->getError('email-1-invalid').'
				'.$this->getError('email-unavailable').'
				<input id="email-2" name="email-2" class="input extend" value="'.$this->getText('email-2').'" placeholder="'.$this->getTextFromDatabase('confirmation').'"/>
				'.$this->getError('email-2-empty').'
				'.$this->getError('email-2-invalid').'
				'.$this->getError('email-different').'
				
				<h2 class="label left">'.$this->getTextFromDatabase('password').'</h2>
				<input id="password-1" name="password-1" type="password" class="input extend" placeholder="'.$this->getTextFromDatabase('password').'"/>
				'.$this->getError('password-1-empty').'
				<input id="password-2" name="password-2" type="password" class="input extend" placeholder="'.$this->getTextFromDatabase('confirmation').'"/>
				'.$this->getError('password-2-empty').'
				'.$this->getError('password-different').'
				
				<input id="submit" name="submit" class="button extend" type="submit" value="'.$this->getTextFromDatabase('register').'" >
				'.$this->getError('registration-failed').'
				'.$this->getError('send-email-failed').'
				'.$this->getSuccess('registration-successful').'
				
				
			</form>
			
		</section>
		';
		return $middle;
	}
}
?>
