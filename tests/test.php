<?php
function autoloader($class)
{
    $include = __DIR__ . '/../Soneritics/' . $class . '.php';
    require_once $include;
}
spl_autoload_register('autoloader');

\Database\DatabaseConnectionFactory::create(
    'sandbox',
    [
        'type' => 'PDOMySQL',
        'dsn' => 'mysql:dbname=sandbox;host=localhost',
        'user' => 'sandbox',
        'password' => 'sandbox'
    ]
);

$tables = Database\Database::getTables();
foreach ($tables as $table) {
    print_r($table);
    print_r($table->getColumns());
}
