<?php
$dsn = 'mysql:host='._DB_SERVER_.';dbname='._DB_NAME_;
$username = _DB_USER_;
$password = _DB_PASSWD_;
try {
    // Create a PDO connection
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>