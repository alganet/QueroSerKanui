<?php
// Usage: php kanois.php
// Usage: php kanois.php 1 100
// Usage: php kanois.php 10 1000000000
// Usage: php kanois.php 10 1000000000 5=Ka 7=Nois
// Usage: php kanois.php 10 1000000000 2=Foo 3=Bar 5=Baz

error_reporting(E_ALL);
version_compare(PHP_VERSION, '5.3.0', '>=') or die('Upgrade to latest PHP');

// Default and argument values
$start     = isset($argv[1]) ? $argv[1] : 1; 
$end       = $start + (isset($argv[2]) ? $argv[2] : 100);
$multiples = isset($argv[3])
           ? parse_ini_string(implode(PHP_EOL, array_slice($argv, 3)))
           : array(7 => "Nois", 5 => "Ka");

// Sort multiples by largest
krsort($multiples);

// Checking integer limits
if ($start > PHP_INT_MAX || $end > PHP_INT_MAX) {
	echo 'Max: '. PHP_INT_MAX . PHP_EOL;
	exit;
}

for ($i = $start; $i < $end; $i++) {
	foreach ($multiples as $d => $s) {
		if (0 == $i % $d) {
			echo $s.PHP_EOL;
			// If found, don't try another multiple
			break;
		}
	}
	// If not found, print the number
	echo $i . PHP_EOL;
}