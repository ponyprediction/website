<?php
include_once ('./php/pages/page.php');

class PredictionsPage extends Page
{
    private $date;
    private $predictions;


    public function compute()
    {
        parent::compute();
        $this->initDate();
        $this->initPredictions();
    }


    public function getMiddle()
    {
        $middle = '<section id="predictions" class="main">
			<h1>' .
                 $this->getTextFromDatabase("predictions-for") . ' ' .
                 $this->getText('date') . '
            </h1>' . $this->predictions . '
		</section>';
        return $middle;
    }


    private function initDate()
    {
        $this->date = "2014-01-01";
        $this->setText('date', $this->date);
    }


    private function initPredictions()
    {
        $ok = true;
        $this->predictions = "";
        $arrayPredictions = $this->databaseManager->getPredictions($this->date);
        foreach ($arrayPredictions as $prediction)
        {
            $table = '<table style="width:100%">';
            foreach ($prediction['outputs'] as $output)
            {
                $ratio = ($output['ratio'] + 1.0) / 2.0;
                $table = $table . '<tr> <td>' . $output['id'] . '</td> <td>' .
                         $ratio . '</td> </tr>';
            }
            $table = $table . '</table>';
            $this->predictions = $this->predictions . '<h2>' . $prediction['id'] .
                     '</h2>' . $table;
        }
    }
}
?>