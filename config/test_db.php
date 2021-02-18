<?php
use yii\helpers\ArrayHelper as ArrayHelperAlias;

$db = ArrayHelperAlias::merge(
    require __DIR__ . '/db-local.php',
    require __DIR__ . '/db.php'
);

// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';

return $db;
