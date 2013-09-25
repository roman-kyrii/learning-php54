<?php

function printResult($explanation, $result)
{
    $newLine = "\n";
    echo $explanation . " - " . $result . $newLine;
}


/*
 *      Arrays
 */


function generateRandomArray($n, $min, $max)
{
    $result = array();

    for ($i = 0; $i < $n; $i++) {
        $result[] = rand($min, $max);
    }

    return $result;
}


$tmpArray = generateRandomArray(6, 0, 20);
$array = $tmpArray;


printResult("array is", implode(", ", $array));
printResult("count(array)", count($array));

function customCount($array)
{
    if (! is_array($array)) {
        return -1;
    }

    $arraySize = 0;

    while (isset($array[$arraySize])) {
        $arraySize++;
    }

    return $arraySize;
}

printResult("customCount(array)", customCount($array));
printResult("sum(array)", array_sum($array));
printResult("max(array)", max($array));

sort($array);
printResult("sort", implode(", ", $array));

function bubbleSort(&$array)
{
    for ($i = 0; $i < count($array) - 1; $i++) {
        for ($j = 0; $j < count($array) - $i - 1; $j++) {
            if ($array[$j] > $array[$j+1]) {
                $tmp = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $tmp;
            }
        }
    }
}

$array = $tmpArray;
bubbleSort($array);
printResult("bubbleSort(array)", implode(", ", $array));


/*
 *      Factorial
 */


function factorial($n)
{
    if ($n == 1 || $n == 0) {
        return 1;
    }
    return factorial($n - 1) * $n;
}

$n = 5;
printResult("factorial($n)", factorial($n));


/*
 *      Strings
 */


$string = " abc ";
printResult("trim($string)", trim($string));

function customTrim($string)
{
    while ($string[0] == ' ') {
        $string = substr($string, 1, strlen($string)-1);
    }

    while ($string[strlen($string)-1] == ' ') {
        $string = substr($string, 0, strlen($string)-1);
    }

    return $string;
}

$string = "  abc abc ";
printResult("customTrim($string)", customTrim($string));

$string = "abc efgh";
printResult("strlen($string)", strlen($string));

function customStrlen($string)
{
    if (! is_string($string)) {
        return -1;
    }

    $stringLength = 0;

    while (isset($string[$stringLength])) {
        $stringLength++;
    }

    return $stringLength;
}


printResult("customStrlen($string))", customStrlen($string));
printResult("customStrlen(''))", customStrlen(''));

$email = "username@mail.com";
$valid = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'valid' : 'not valid';
printResult("filter_var($email)", $valid);


/*
 *      Files
 */


$fileName = "test_file";

$linesCount = count(file($fileName));
printResult("lines in file", $linesCount);


function countBlocksInFile($fileName, array $blockSeparators)
{
    if (! $file = fopen($fileName, 'r')) {
        return false;
    }

    $blockCount = 0;

    while (!feof($file)) {
        $line = fgets($file);
        if (in_array($line, $blockSeparators)) {
            $blockCount++;
        }
    }
    fclose($file);

    return $blockCount;
}

printResult("paragraphs in file", countBlocksInFile($fileName, array("\n", "\r\n")));

$recordSeparator = '--rs--';
printResult("records in file", countBlocksInFile($fileName, array($recordSeparator)));



// Char Statistics

$fileContents = file_get_contents($fileName);
$charCount = count_chars($fileContents, 1);

foreach ($charCount as $key => $value) {
    if (in_array($key, array("10","32"))) {
        unset($charCount[$key]);
        continue;
    }

    echo chr($key) . ' => ' . $value . "\n";
}



// Words that start with particular letter

function getWordsThatStartWithLetter($fileName, $letter) {
    $fileContents = file_get_contents($fileName);
    $words = str_word_count($fileContents, 1);
    $result = array();
    foreach ($words as $word) {
        if ($word[0] == $letter and !in_array($word, $result)) {
            $result[] = $word;
        }
    }

    return $result;
}

$letter = "a";
$words = getWordsThatStartWithLetter($fileName, $letter);
$words = implode(", ", $words);
printResult("wodrs that start with letter '$letter'", $words);
