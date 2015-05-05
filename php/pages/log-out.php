<?php
include_once('./php/pages/page.php');

class LogOutPage extends Page
{
	protected $previews;
    public function compute()
    {
        parent::compute();
		if(!$_SESSION['user']->isConnected())
			header('Location: '.Constants::$ROOT_URL.'/error/404');
		$_SESSION['user'] = new User('', false);
		$_SESSION['just-log-out'] = true;
		header('Location: '.Constants::$ROOT_URL.'/home');
    }
	public function getMiddle()
	{
		$middle = '
		<section id="sign-in" class="main">
			<p>
				'.$this->getTextFromDatabase('bye').'
			</p>
		</section>
		';
		return $middle;
	}
}
?>
