<?php
/**
 * Placeholder for data table objects, subject to change
 * As far as how to return the data, it could be number of rows and then the data itself
 *  - i.e. return array("num_rows"=>x, "data"=>array("columnName"=>"columnVal", ... ))
 *  - if many rows return with "data"=> formatted as "array("row1"=>array("colName"=>"colVal"))" or array("colName"=>"colVal")?
 *      - in the second option you would know you're on a new row when the column names start to repeat (of course we know what to expect tho)
 * 
 * ====================NOTE: Insert and update may be able to be the same function with a flag set====================
 * Needed functions?:
 *  - constructor
 *      - create or connect to a data table object
 *  - insert
 *      - takes a key,value array an input (keys == column names)
 *      - creates a query based on the input array
 *      - queries the database
 *      - returns: could be success/failed codes or just nothing
 *  - update
 *      - takes a key,value array as input (keys == column names)
 *      - creates a query based on the input aray
 *      - queries the database
 *      - returns: could be success/failed codes or just nothing
 *  - select
 *      - input is either personID/familyID/null
 *      - calls a select * to with the given input
 *          - null would be select * from Table;
 *          - with an identifier would be select * from Table where identifier=input;
 *      - return the data (TODO 6/6/22: HOW DO WE WANT THE RETURNS FORMATTED?)
 *  - removeRow
 *      - input is familyID and number of rows to remove
 *      - takes the last (input) rows in the table associated with the familyID and deletes them
 */

class DataTableObject {
    function __construct() {
        
    }
}
?>