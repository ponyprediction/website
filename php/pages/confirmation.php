<?php
include_once ('./php/pages/page.php');

class ConfirmationPage extends Page
{


    public function compute ()
    {
        parent::compute();
        $this->errors['confirmation-failed'] = false;
        $this->success['confirmation-sucessful'] = false;
        $ok = true;
        if ($ok && ! isset($_GET['confirmation']))
        {
            $ok = false;
        }
        if ($ok && ! $this->databaseManager->confirmEmail($_GET['confirmation']))
        {
            $ok = false;
        }
        if (! $ok)
        {
            $this->errors['confirmation-failed'] = true;
        }
        if ($ok)
        {
            $this->success['confirmation-sucessful'] = true;
        }
    }


    public function getMiddle ()
    {
        $middle = '<section id="confirmation" class="main">
			' . $this->getError('confirmation-failed') . '
			' . $this->getSuccess('confirmation-sucessful') . '
		</section>';
        return $middle;
    }
}
?>
