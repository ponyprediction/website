<?php
include_once ('./php/pages/page.php');

class PredictionsPage extends Page
{
    private $date;
    private $yesterday;
    private $tomorrow;
    private $predictions;
    private $money;


    public function compute()
    {
        parent::compute();
        $this->setText('morning-odds', 
                $this->getTextFromDatabase('morning-odds'));
        $this->setText('pronostic', $this->getTextFromDatabase('pronostic'));
        $this->setText('number', $this->getTextFromDatabase('number'));
        $this->setText('ratio', $this->getTextFromDatabase('ratio'));
        $this->setText('single-show', $this->getTextFromDatabase('single-show'));
        
        $this->setText('pony-count', 
                $this->getTextFromDatabase('pony-count'));
        $this->setText('races', $this->getTextFromDatabase('races'));
        $this->setText('winnings', $this->getTextFromDatabase('winnings'));
        $this->setText('earnings', $this->getTextFromDatabase('earnings'));
        $this->setText('average-earnings', 
                $this->getTextFromDatabase('average-earnings'));
                $this->setText('success', 
                $this->getTextFromDatabase('success'));
        
        $this->initDate();
        $this->initPredictions();
    }


    public function getMiddle()
    {
        $linkYesterday = '<a href="' . $this->root . '/predictions/' .
                 $this->getText('yesterday') . '">←</a>';
        $linkTomorrow = '<a href="' . $this->root . '/predictions/' .
                 $this->getText('tomorrow') . '">→</a>';
        $middle = '<section id="predictions" class="main"> 
			<h1>' . $linkYesterday . ' ' . $this->getText('date') . ' ' . $linkTomorrow . '
            </h1>' . $this->money . $this->predictions . '
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
        $this->yesterday = date("Y-m-d", 
                strtotime("-1 days", strtotime($this->date)));
        $this->tomorrow = date("Y-m-d", 
                strtotime("+1 days", strtotime($this->date)));
        $this->setText('date', $this->date);
        $this->setText('yesterday', $this->yesterday);
        $this->setText('tomorrow', $this->tomorrow);
    }


    private function initPredictions()
    {
        $ok = true;
        $moneyData = "";
        $this->predictions = "";
        $arrayPredictions = $this->databaseManager->getPredictions($this->date);
        
        foreach ($arrayPredictions as $prediction)
        {
            $table = '<table> <tr> <th>' . $this->getText('pronostic') .
                     '</th> <th>' . $this->getText('number') . '</th> <th>' .
                     $this->getText('ratio') . '</th> <th>' .
                     $this->getText('morning-odds') . '</th> <th>' .
                     $this->getText('single-show') . '</th></tr>';
            
            $teams = $this->databaseManager->getTeamsFromRace($prediction['id']);
            $winnings = $this->databaseManager->getWinningsFromRace(
                    $prediction['id']);
            $singleShow = $winnings['singleShow'];
            
            $rank = 0;
            $winningToAdd = 0;
            foreach ($prediction['outputs'] as $output)
            {
                $id = $output['id'];
                $odds = number_format($teams[$id - 1]['odds'], 1);
                
                $ratio = number_format($output['ratio'], 6);
                $winning = "";
                
                if (isset($teams[$id - 1]['odds']))
                {
                    $rank ++;
                    foreach ($singleShow as $v)
                    {
                        if ($v['id'] == $id)
                        {
                            $winning = $v['winning'];
                            if ($rank == 1)
                            {
                                $winningToAdd = $winning;
                            }
                        }
                    }
                    
                    $table = $table . '<tr> <td>' . $rank . '</td> <td>' . $id .
                             '</td> <td>' . $ratio . '</td> <td>' . $odds .
                             '</td> <td>' . $winning . '</td></tr>';
                }
            }
            $moneyData[0]['races'] = $moneyData[0]['races'] + 1;
            $moneyData[0]['winnings'] = $moneyData[0]['winnings'] + $winningToAdd;
            $moneyData[$rank]['races'] = $moneyData[$rank]['races'] + 1;
            $moneyData[$rank]['winnings'] = $moneyData[$rank]['winnings'] +
                     $winningToAdd;
            if ($winningToAdd)
            {
                $moneyData[0]['success'] = $moneyData[0]['success'] + 1;
                $moneyData[$rank]['success'] = $moneyData[$rank]['success'] + 1;
            }
            
            $table = $table . '</table>';
            $this->predictions = $this->predictions . '<h2>' . $prediction['id'] .
                     '</h2>' . $table;
        }
        //
        if ($moneyData[0]['races'])
        {
            $this->money = '<table> <tr> <th>' . $this->getText('pony-count') .
                     '</th> <th>' . $this->getText('races') . '</th> <th>' .
                     $this->getText('winnings') . '</th> <th>' .
                     $this->getText('earnings') . '</th> <th>' .
                     $this->getText('average-earnings') . '</th> <th>' .
                     $this->getText('success') . '</th> <th>' .
                     $this->getText('ratio') . '</th> </tr>';
            //
            for ($i = 0; $i < 21; $i ++)
            {
                if ($moneyData[$i]['races'])
                {
                    $a = $moneyData[$i]['races'];
                    $b = number_format($moneyData[$i]['winnings'], 2);
                    $c = number_format(
                            ($moneyData[$i]['winnings'] - $moneyData[$i]['races']), 
                            2);
                    $d = number_format(
                            ($moneyData[$i]['winnings'] - $moneyData[$i]['races']) /
                                     $moneyData[$i]['races'], 2);
                    $e = $moneyData[$i]['success'];
                    $f = number_format(
                            $moneyData[$i]['success'] / $moneyData[$i]['races'], 
                            2);
                    if(!$i)
                        $i = "";
                    $this->money = $this->money . '<tr> <td>' . $i . '</td> <td>' .
                             $a . '</td> <td>' . $b . '</td> <td>' . $c .
                             '</td> <td>' . $d . '</td> <td>' . $e . '</td><td>' . $f . '</td></tr>';
                }
            }
            $this->money = $this->money . '</table>';
        }
    }
}
?>