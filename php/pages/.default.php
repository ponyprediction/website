<?php
include_once('./php/pages/page.php');

class DefaultPage extends Page
{
	protected $previews;
    public function compute()
    {
        parent::compute();
    }
	public function getMiddle()
	{
		$middle = '
		<section id="default" class="main">
			<p class="section">
				'.$this->getText('default').'
			</p>
		</section>
		';
		return $middle;
	}
}
?>
