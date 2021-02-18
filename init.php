<?php

$config_folder = __DIR__ . DIRECTORY_SEPARATOR . 'config';

$list_of_files = array_diff(scandir($config_folder), ['.', '..']);
$generate_files = ['web-local.php', 'console-local.php', 'db-local.php', 'params-local.php'];

chdir('config');
foreach ($generate_files as $file_name) {

    if (in_array($file_name, $list_of_files, true)) {
        continue;
    }

    $file = fopen($file_name, 'wb') or die("Unable to open file!");
    fwrite($file, "<?php\n\nreturn [];");
    fclose($file);

}