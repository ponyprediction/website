<?php
include_once('./php/pages/page.php');

class AccountPage extends Page
{
	protected $previews;
    public function compute()
    {
        parent::compute();
		$this->setText('username', $_SESSION['user']->getUsername());
		$this->setText('email', $_SESSION['user']->getEmail());
		$this->setText('new-username', '');
		$this->setText('new-email', '');
    }
	public function getMiddle()
	{
		$middle = '
		<section id="account" class="main">
			
			<h2>'.$this->getText('username').'</h2>
			<form id="change-username-form" action="" method="post" class="horizontal">
				<input id="new-username" name="new-username" class="input extend left" placeholder="'.$this->getTextFromDatabase('new-username').'" value="'.$this->getText('new-username').'"/>
				<input id="submit-change-username" name="submit-change-username" class="button right" type="submit" value="'.$this->getTextFromDatabase('change').'" >
			</form>
			
			<h2>'.$this->getText('email').'</h2>
			<form id="change-email-form" action="" method="post" class="horizontal">
				<input id="new-email" name="new-email" class="input extend left" placeholder="'.$this->getTextFromDatabase('new-email').'" value="'.$this->getText('new-email').'"/>
				<input id="submit-change-email" name="submit-change-email" class="button right" type="submit" value="'.$this->getTextFromDatabase('change').'" >
			</form>
			
			<h2>'.$this->getTextFromDatabase('password').'</h2>
			<form id="change-email-form" action="" method="post" class="horizontal">
				<div class="vertical extend">
					<input id="new-email" name="new-email" class="input extend left" placeholder="'.$this->getTextFromDatabase('current-password').'"/>
					<input id="new-email" name="new-email" class="input extend left" placeholder="'.$this->getTextFromDatabase('new-password').'"/>
					<input id="new-email" name="new-email" class="input extend left" placeholder="'.$this->getTextFromDatabase('confirmation').'"/>
				</div>
				
				<input id="submit-change-email" name="submit-change-email" class="button right bottom" type="submit" value="'.$this->getTextFromDatabase('change').'" >
			</form>
			
		</section>
		';
		return $middle;
	}
}
?>
