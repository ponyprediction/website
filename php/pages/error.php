<?php
include_once('./php/pages/page.php');
class ErrorPage extends Page
{
	//private $text;
    public function compute()
	{
        parent::compute();
		$ok = true;
		if(!isset($_GET['error']))
			$ok = false;
		if($ok && $_GET['error'] != '404')
			$ok = false;
		if($ok)
		{
			$this->text['error'] = $this->getTextFromDatabase('404');
			$this->html['title'] = $this->getTextFromDatabase('404-title');
		}
        if(!$ok)
            header('Location: '.Constants::$ROOT_URL.'/error/404');
    }
	public function getMiddle()
	{
	    return'
	        <section id="error" class="main">
	            <p>'.$this->text['error'].'</p>
	        </section>
	    ';
	}
}
?>
