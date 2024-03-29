# test_postgre.php
<?php
$host = '172.24.128.1';
$db = 'dev';
$user = 'postgres';
$pass = '1234';
$port = '5434';

$db_handle = pg_connect("host={$host} port={$port} dbname={$db} user={$user} password={$pass}");

if ($db_handle) {
    echo "\nConnection attempt succeeded. \n\n";
} else {
    echo "\nConnection attempt failed. \n\n";
}

echo "Connection Information\n";
echo "======================\n\n";

echo "DATABASE NAME:" . pg_dbname($db_handle) . "\n";
echo "HOSTNAME: " . pg_host($db_handle) . "\n";
echo "PORT: " . pg_port($db_handle) . "\n\n";

// php test_postgres.php