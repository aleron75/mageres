<?php declare(strict_types=1); 

/**
 * This script generates a CSV containing just the Extensions to feed GPT
 */
if (!isset($argv[2])) {
  echo "Usage: php csv2gpt.php input_file output_file.csv" . PHP_EOL;
  exit(1);
}

$csv = $argv[1];
if (!file_exists($csv)) {
  echo "File not found: $csv" . PHP_EOL;
  exit(1);
}

$outfile = $argv[2];
if ($csv == $outfile) {
  echo "Cannot write on input file!" . PHP_EOL;
  exit(1);
}

$contents = [
    ['Extension name', 'Extension URL', 'Extension Description']
];
$topic = '';
$prevtopic = '';
if (($handle = fopen($csv, "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        list($topic, $_, $name, $url, $description) = $data;

        if ($topic !== 'Extensions' ) {
            continue;
        }

        $contents[] = [
            $name,
            $url,
            $description,
        ];
    }
    fclose($handle);
}
#print_r($contents);

$handle = fopen($outfile, 'w');
foreach ($contents as $content) {
    fputcsv($handle, $content);
}
fclose($handle);