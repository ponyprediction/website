<?php
include_once ('./php/pages/page.php');

class PredictionsPage extends Page
{
    private $date;
    private $predictions;
    private $totalWinnings;
    private $raceCount;


    public function compute()
    {
        parent::compute();
        $this->setText('morning-odds', 
                $this->getTextFromDatabase('morning-odds'));
        $this->setText('pronostic', $this->getTextFromDatabase('pronostic'));
        $this->setText('number', $this->getTextFromDatabase('number'));
        $this->setText('ratio', $this->getTextFromDatabase('ratio'));
        $this->setText('single-show', $this->getTextFromDatabase('single-show'));
        $this->initDate();
        $this->initPredictions();
    }


    public function getMiddle()
    {
        $middle = '<section id="predictions" class="main">
			<h1>' .
                 $this->getTextFromDatabase("predictions-for") . ' ' .
                 $this->getText('date') . '
            </h1>'.
            '<p>Bénéfices ' . ($this->totalWinnings - $this->raceCount) . '</p>' .
            '<p>Bénéfices moyen ' . ($this->totalWinnings - $this->raceCount) / $this->raceCount . '</p>' .
            '<p>Courses ' . $this->raceCount . '</p>' .
            '<p>Gains ' . $this->totalWinnings . '</p>' .
                 $this->predictions . '
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
        $this->setText('date', $this->date);
    }


    private function initPredictions()
    {
        $ok = true;
        $this->totalWinnings = 0;
        $this->raceCount = 0;
        $this->predictions = "";
        $arrayPredictions = $this->databaseManager->getPredictions($this->date);
        foreach ($arrayPredictions as $prediction)
        {
            $this->raceCount ++;
            $table = '<table> <tr> <th>' . $this->getText('pronostic') . '</th> <th>' .
                     $this->getText('number') . '</th> <th>' .
                     $this->getText('ratio') . '</th> <th>' .
                     $this->getText('morning-odds') . '</th> <th>' .
                     $this->getText('single-show') . '</th>.</tr>';
            
            $teams = $this->databaseManager->getTeamsFromRace($prediction['id']);
            $winnings = $this->databaseManager->getWinningsFromRace(
                    $prediction['id']);
            $singleShow = $winnings['singleShow'];
            $rank = 0;
            
            foreach ($prediction['outputs'] as $output)
            {
                $id = $output['id'];
                $odds = number_format($teams[$id - 1]['odds'], 1);
                
                $ratio = number_format($output['ratio'], 6);
                
                
                
                if (isset($teams[$id - 1]['odds']))
                {
                    $rank ++;
                    $winning = "";
                    foreach ($singleShow as $v)
                    {
                        if ($v['id'] == $id)
                        {
                            $winning = $v['winning'];
                            if ($rank == 1)
                            {
                                $this->totalWinnings = $this->totalWinnings +
                                $winning;
                            }
                        }
                    }
                    
                    $table = $table . '<tr> <td>' . $rank . '</td> <td>' . $id .
                             '</td> <td>' . $ratio . '</td> <td>' . $odds .
                             '</td> <td>' . $winning . '</td></tr>';
                }
            }
            $table = $table . '</table>';
            $this->predictions = $this->predictions . '<h2>' . $prediction['id'] .
                     '</h2>' . $table;
        }
    }
}
?>