<?php
if (!isset($argv[2])) {
  echo "Usage: php md2csv.php path_to_input_file output_file.csv" . PHP_EOL;
  exit(1);
}

$file = $argv[1];
if (!file_exists($file)) {
  echo "File not found: $file" . PHP_EOL;
  exit(1);
}

$output = $argv[2];

$content = explode("\n", file_get_contents($file));
$csv = [];
$currentTopic = 'Uncategorized';
$currentSubtopic = '';
foreach ($content as $i => $line) {
  if (empty($line)) {
    continue;
  }

  if (substr($line, 0, 3) == '###') {
    $currentSubtopic = substr($line, 4);
  }

  if (substr($line, 0, 3) == '## ') {
    $currentTopic = substr($line, 3);
  }

  $cols = explode(' - ', $line);
  $desc = '';
  if (isset($cols[1])) {
    $desc = $cols[1];
  }
  $line = $cols[0];

  preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $line, $match);
  if (!isset($match[0][0])) {
    continue;
  }

  $titleStart = strpos($line, '[');
  $titleEnd = strpos($line, ']');
  $title = substr($line, $titleStart + 1, $titleEnd - $titleStart - 1);
  print_r([
    'line' => $line,
    'titlestart' => $titleStart,
    'titleend' => $titleEnd,
  ]);

  $url = $match[0][0];
  $host = parse_url($url);
  if (!$host) {
    continue;
  }
  $csv[] = [
    'topic' => trim($currentTopic),
    'subtopic' => trim($currentSubtopic),
    'title' => trim($title),
    'url' => trim($host['scheme']  . '://' . $host['host'] . $host['path']),
    'description' => trim($desc),
  ];
  // $host['description'] = $desc;
  // print_r($host);
}
#print_r($csv);
$fp = fopen($output, 'w');
foreach ($csv as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);
