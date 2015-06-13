<?php
include_once ('./php/pages/page.php');

class HomePage extends Page
{
    protected $previews;


    public function compute()
    {
        parent::compute();
    }


    public function getMiddle()
    {
        $middle = '
		<section id="home" class="main ">
			' . $this->getInfo('just-log-in') . '
			' . $this->getInfo('just-log-out') . '
			<h1>' .
                 $this->getTextFromDatabase('home-h1') . '</h1>
			<p>' .
                 $this->getTextFromDatabase('home-p-0') . '</p>
			<h2>' .
                 $this->getTextFromDatabase('home-neural-network-h2') . '</h2>
			<p>' .
                 $this->getTextFromDatabase('home-neural-network-p-1') . '</p>
			<p>' .
                 $this->getTextFromDatabase('home-neural-network-p-2') . '</p>
			<h2>' .
                 $this->getTextFromDatabase('home-h2-1') . '</h2>
			<p>' .
                 $this->getTextFromDatabase('home-p-1') . '</p>
		</section>
		';
        return $middle;
    }
}
?>
