<?php
include_once ('./php/pages/page.php');

class PredictionsPage extends Page
{
    private $date;
    private $predictions;


    public function compute()
    {
        parent::compute();
        $this->setText('morning-odds', $this->getTextFromDatabase('morning-odds'));
        $this->setText('rank', $this->getTextFromDatabase('rank'));
        $this->setText('number', $this->getTextFromDatabase('number'));
        $this->setText('ratio', $this->getTextFromDatabase('ratio'));
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
        if (isset($_GET['date']))
        {
            $this->date = (string) $_GET['date'];
        }
        else
        {
            $this->date = date("Y-m-d");
        }
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
            $table = '<table> <tr> <th>' . $this->getText('rank') . '</th> <th>' .
                     $this->getText('number') . '</th> <th>' .
                     $this->getText('ratio') . '</th> <th>' .
                     $this->getText('morning-odds') . '</th> </tr>';
            
            $teams = $this->databaseManager->getTeamsFromRace($prediction['id']);
            $rank = 0;
            
            foreach ($prediction['outputs'] as $output)
            {
                $id = $output['id'];
                $odds = number_format($teams[$id - 1]['odds'], 1);
                $rank ++;
                $ratio = number_format($output['ratio'], 6);
                if (isset($teams[$id - 1]['odds']))
                {
                    $table = $table . '<tr> <td>' . $rank . '</td> <td>' . $id .
                             '</td> <td>' . $ratio . '</td> <td>' . $odds .
                             '</td> </tr>';
                }
            }
            $table = $table . '</table>';
            $this->predictions = $this->predictions . '<h2>' . $prediction['id'] .
                     '</h2>' . $table;
        }
    }
}
?>