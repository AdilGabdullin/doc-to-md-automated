<?php

function generateMarkdown(string $fileName): string
{
    $blocks = explode("\r\n\r\n", file_get_contents($fileName));
    $result = '';
    foreach ($blocks as $block) {
        if ($block[0] === '#') {
            // as is
            $result .= $block . PHP_EOL;
        } else {
            // table
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

    // Table head
    $tableHead = '|';
    for ($j = 0; $j < $columnsNum; $j++) {
        $tableHead .= $lines[$j + 1] . '|';
    }
    $result = $tableHead . PHP_EOL;
    $result .= preg_replace('/[^|]/', '-', $tableHead) . PHP_EOL;

    // Table body
    for ($i = 1; $i < $rowsNum; $i++) {
        $row = '|';
        for ($j = 0; $j < $columnsNum; $j++) {
            $row .= $lines[$j + 1 + $i * $columnsNum] . '|';
        }
        $result .= $row . PHP_EOL;
    }
    return $result;
}

$result = generateMarkdown('input.txt');
echo $result;
file_put_contents('Metric descriptions and glossary.md', $result);
