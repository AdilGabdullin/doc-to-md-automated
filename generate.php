<?php
require_once 'TextTable.php';

function generateTable($fileName, $columnsNum)
{
    $data = file_get_contents($fileName);
    $lines = explode("\r\n", $data);
    $columns = array_slice($lines, 0, $columnsNum);
    $rows = [];
    $stop = count($lines) / $columnsNum - 1;
    for ($i = 1; $i < $stop; $i++) {
        $rows[] = array_slice($lines, $i * $columnsNum, $columnsNum);
    }
    $t = new TextTable($columns, $rows);
    return $t->render() . PHP_EOL;
}

$result = '# Metric descriptions for Workplace Analytics' . PHP_EOL;
$result .= '## Person metrics' . PHP_EOL;
$result .= generateTable('input/person metrics.txt', 3);
$result .= '## Meeting metrics'. PHP_EOL;
$result .= generateTable('input/meeting metrics.txt', 3);
$result .= '## Group metrics'. PHP_EOL;
$result .= generateTable('input/group metrics.txt', 3);
$result .= '# Glossary for Workplace Analytics'. PHP_EOL;
$result .= generateTable('input/Glossary for Workplace Analytics.txt', 2);

echo $result;
file_put_contents('Metric descriptions and glossary.md', $result);
