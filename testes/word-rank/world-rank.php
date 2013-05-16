<?php
// Usage: php world-rank.php
// Usage: php world-rank.php data.txt
// Usage: php world-rank.php data.txt "-'()"

error_reporting(E_ALL);
version_compare(PHP_VERSION, '5.3.0', '>=') or die('Upgrade to latest PHP');


$file_name = isset($argv[1]) ? $argv[1] : 'data.txt';
$wordchars = isset($argv[2]) ? $argv[2] : "-'"; 
$real_file  = realpath($file_name);

// Checking for file sanity
if (!$real_file || !file_exists($real_file) || !is_readable($real_file)) {
	echo "Error on file $file_name\n";
	die;
}

$file_data = file_get_contents($real_file);
// Converting to ASCII to compare without locale interference
$file_data = mb_convert_encoding(
	$file_data, 
	'ASCII', 
	mb_detect_encoding($file_data, 'UTF-8, ISO-8859-1', true)
);
// str_word_count actually returns all words, don't count them
$words = str_word_count($file_data, 1, $wordchars);
$words = array_map('strtolower', $words);
// Removing words that are just single word-separating characters
$words = array_diff($words, str_split($wordchars));
// Actually counting the values
$words = array_count_values(array_filter($words));
// Sorting them reversed by associative key
arsort($words);

foreach ($words as $word => $n) {
	echo "$word $n\n";
}