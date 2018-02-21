<?php
require_once 'TextTable.php';

function automate(string $fileName): string
{
    $data = file_get_contents($fileName);
    $blocks = explode("\r\n\r\n", $data);
    $result = '';
    foreach ($blocks as $block) {
        if ($block[0] === '#') {
            $result .= $block . PHP_EOL;
        } else {
            $result .= generateTable($block);
        }
    }
    return $result;
}

function generateTable(string $data): string
{
    $lines = explode("\r\n", $data);
    $columnsNum = (int)$lines[0];
    $rowsNum = (count($lines) - 1) / $columnsNum;

    $tableHead = '|';
    for ($j = 0; $j < $columnsNum; $j++) {
        $tableHead .= $lines[$j + 1] . '|';
    }
    $result = $tableHead . PHP_EOL;
    $result .= preg_replace('/[^|]/', '-', $tableHead) . PHP_EOL;


    for ($i = 1; $i < $rowsNum; $i++) {
        $row = '|';
        for ($j = 0; $j < $columnsNum; $j++) {
            $row .= $lines[$j + 1 + $i * $columnsNum] . '|';
        }
        $result .= $row . PHP_EOL;
    }
    return $result;
}

$result = automate('input.txt');
echo $result;
file_put_contents('Metric descriptions and glossary.md', $result);
//$result = '# Metric descriptions for Workplace Analytics' . PHP_EOL;
//$result .= '## Person metrics' . PHP_EOL;
//$result .= generateTable('input/person metrics.txt', 3);
//$result .= '## Meeting metrics'. PHP_EOL;
//$result .= generateTable('input/meeting metrics.txt', 3);
//$result .= '## Group metrics'. PHP_EOL;
//$result .= generateTable('input/group metrics.txt', 3);
//$result .= '# Glossary for Workplace Analytics'. PHP_EOL;
//$result .= generateTable('input/Glossary for Workplace Analytics.txt', 2);
//
//echo $result;
//file_put_contents('Metric descriptions and glossary.md', $result);
