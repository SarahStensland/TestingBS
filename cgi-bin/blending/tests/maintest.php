<?php
/**
 * I want this page to be a main function for the data table object tests
 */

 require_once "../DataTableObject.php";

 function main() {
    $dtObj = new DataTableObject("Person", array("personID", "firstName", "lastName", "gender", "email", "hash", "paid", "leader", "dateJoined", 
        "ip", "zipCode", "canShare"), array("int", "varchar", "varchar", "int", "varchar", "varchar", "tinyint", "tinyint", "date", "varchar", 
        "varchar", "tinyint"), "personID");

    echo "Object:<pre>".print_r($dtObj)."</pre>";
 }
?>