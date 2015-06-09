<?php

include_once('./php/other/database-manager.php');
include_once('./php/other/user.php');
include_once('../website.conf');

class Page {
	protected $html;
	protected $root;
	protected $rootDir;
	protected $databaseManager;
	protected $pageTitle;
	protected $text;
	protected $errors;
	protected $success;
	protected $infos;
	protected $user;
	public function __construct($pageTitle)
	{
	    $this->pageTitle = $pageTitle;
		$this->html['title'] = '';
        $this->html['header'] = '';
        $this->html['middle'] = '';
        $this->html['footer'] = '';
		$this->html['javascript'] = '';
		$this->html['css'] = '';
        $this->compute();
        $this->display();
	}
	public function compute()
	{
		//  Session
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		// Session
		if(!isset($_SESSION['user']))
			$_SESSION['user'] = new User();
		if(!isset($_SESSION['language']))
            $_SESSION['language'] = 'french';
		if(!isset($_SESSION['just-log-in']))
			$_SESSION['just-log-in'] = false;
		if(!isset($_SESSION['just-log-out']))
			$_SESSION['just-log-out'] = false;
		$this->infos['just-log-in']  = $_SESSION['just-log-in'];
		$this->infos['just-log-out']  = $_SESSION['just-log-out'];
		$_SESSION['just-log-in'] = false;
		$_SESSION['just-log-out'] = false;
	    //  DatabaseManager
		$this->databaseManager = new DatabaseManager();
        //  Root directory.
        $this->root = Constants::$ROOT_URL;
		$this->rootDir = getcwd();
		//
        $this->loadCSS($this->root.'/css/global.css');
        $this->loadCSS($this->root.'/css/'.$this->pageTitle.'.css');
		$this->loadJavascript($this->root.'/scripts/'.$this->pageTitle.'.js');
		$this->loadJavascript($this->root.'/scripts/constants.js');
		$this->addJavascript('CONSTANTS = new Constants("'. Constants::$ROOT_URL .'");');
        /*$this->loadJavascript($this->root.'/scripts/change-color.js');
		if(!isset($_SESSION['backgroundColor']))
			$this->addJavascript('randomColor(64, 192);');
	    else
			$this->addJavascript('changeColor("' . $_SESSION['backgroundColor'] .'");');*/
		$this->html['title'] = $this->getTextFromDatabase($this->pageTitle);
	}
	public function display()
	{
		$this->html['middle'] = $this->getMiddle();
		$this->html['header'] = $this->getHeader();
        $this->html['footer'] = $this->getFooter();
echo'<!DOCTYPE html><html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		'.$this->html['css'].'
		'.$this->html['javascript'].'
		
		<title>'.$this->html['title'].'</title>
	</head>
	<body>
		'.$this->html['header'].'
		'.$this->html['middle'].'
		'.$this->html['footer'].'
	</body>
</html>';
    }
    
    public function getHeader()
    {
		// Basic
		$header = '<header class="horizontal">
		    <img class="cell" src="'.Constants::$ROOT_URL.'/images/logo.png" 
		        alt="logo">
		    <div id="navs" class="vertical extend">
			    <div class="extend"></div>
		        <nav id="main-nav" class="horizontal">
				    <a id="home" href="'.$this->root.'/home">'.$this->getTextFromDatabase('home').'</a>
				    <a id="home" href="'.$this->root.'/predictions">'.$this->getTextFromDatabase('predictions').'</a>
			    </nav>
			    <div class="extend"></div>
			    <nav id="nav-options" class="horizontal">
			        <a id="home" href="'.$this->root.'/language">'.$this->getTextFromDatabase('language').'</a>
				    <a id="home" href="'.$this->root.'/options">'.$this->getTextFromDatabase('options').'</a>';
				    if($_SESSION['user']->isConnected())
				    {
					    $header = $header .'
						    <a id="home" href="'.$this->root.'/account">'.$this->getTextFromDatabase('account').'</a>
						    <a id="home" href="'.$this->root.'/log-out">'.$this->getTextFromDatabase('log-out').'</a>
					    ';
				    }
				    if(!$_SESSION['user']->isConnected())
				    {
					    $header = $header .'
						    <a id="home" href="'.$this->root.'/register">'.$this->getTextFromDatabase('register').'</a>
						    <a id="home" href="'.$this->root.'/log-in">'.$this->getTextFromDatabase('log-in').'</a>
					    ';
				    }
				    $header = $header .'
			    </nav>
			    <div class="extend"></div>
		    </div>
	        <img class="cell" src="'.Constants::$ROOT_URL.'/images/logo-reversed.png" 
		        alt="logo-reversed">
		</header>';
		return $header;
    }
    public function getMiddle()
    {
        return '';
    }
    public function getFooter()
	{
		return'
		<footer class="footer">
			<p>'.$this->getTextFromDatabase('footer').'</p>
		</footer>
		';
	}
	public function getError($errorId)
	{
		$error = '<p id="'.$errorId.'" class="error';
		if(!$this->errors[$errorId])
			$error = $error . ' invisible';
		$error = $error . '">'.$this->getTextFromDatabase($errorId).'</p>';
		return $error;
	}
	public function getSuccess($id)
	{
		$success = '<p id="'.$id.'" class="success';
		if(!$this->success[$id])
			$success = $success . ' invisible';
		$success = $success . '">'.$this->getTextFromDatabase($id).'</p>';
		return $success;
	}
	public function getInfo($id)
	{
		$info = '<p id="'.$id.'" class="info';
		if(!$this->infos[$id])
			$info = $info . ' invisible';
		$info = $info . '">'.$this->getTextFromDatabase($id).'</p>';
		return $info;
	}
	
	
	
	
	
	
	public function setText($id, $text)
	{
		$this->text[$id] = $text;
	}
	public function getText($id)
	{
		$text = "";
		if(isset($this->text[$id]))
			$text = htmlspecialchars($this->text[$id], ENT_QUOTES, 'utf-8');
		else
			echo "Can not load text : [" . $id . "]<br/>";
		return $text;
	}
	public function getTextFromDatabase($idText)
	{
		$text = $this->databaseManager->getText($idText);
		$text = htmlspecialchars($text, ENT_QUOTES, 'utf-8');
		if($text == "")
		{
			echo "Can not load text from database : [" . $idText . "]<br/>";
		}
		return $text;
	}
	public function loadCSS($file)
	{
        $this->html['css'] = $this->html['css'] . '
		<link rel="stylesheet" href="'.$file.'"/>';
	}
	public function loadJavascript($file)
	{
        $this->html['javascript'] = $this->html['javascript'] .' 
		<script type="text/javascript" src="'.$file.'" defer></script>';
	}
	public function addJavascript($javascript)
	{
        $this->html['javascript'] = $this->html['javascript'] . '
		<script type="text/javascript" defer>
			document.addEventListener("DOMContentLoaded", function() {
				'. $javascript .'
			});
		</script>';
	}
}
?>
