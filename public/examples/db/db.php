<?php

require_once '../../bootstrap.php';

use Pop\Db\Db;

try {

    // Define DB credentials
    $creds = array(
                 'database' => 'poptest',
                 'host'     => 'localhost',
                 'username' => 'popuser',
                 'password' => '12pop34'
             );

    // Create DB object
    $db = Db::factory('Mysqli', $creds);

    // Perform the query
    $db->adapter->query('SELECT * FROM users');

    // Fetch the results
    while (($row = $db->adapter->fetch()) != false) {
        print_r($row);
    }

    echo PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>