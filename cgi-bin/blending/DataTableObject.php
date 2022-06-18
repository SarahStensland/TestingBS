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
 *      - takes a key, value array as input (keys == column names)
 *      - creates a query based on the input array
 *      - queries the database
 *      - returns: could be success/failed codes or just nothing
 *  - select
 *      - input is either personID/familyID/null
 *      - calls a select * to with the given input
 *          - null would be select * from Table;
 *          - with an identifier would be select * from Table where identifier=input;
 *      - return the data (TODO 6/6/22: HOW DO WE WANT THE RETURNS FORMATTED?)
 *          - the key for each row is the primary key for the row in the table
 *          - the value for each row is "colName"=>"colVal"
 *  *      - overload (2 version for array vs value for input)
 *  - removeRow
 *      - input is familyID and number of rows to remove
 *      - takes the last (input) rows in the table associated with the familyID and deletes them
 *      - TODO 6/17/2022 -- add some way to restrict the number of rows that can be affected
 *  - multiples
 *      - make a function (might be specific) for insert/update-ing multiple rows at once
 *  - typing
 *      - helper function so that the returned values from select are cast to being the correct types
 */

class DataTableObject {
    protected $dbConnection; // the database connection
    protected $tableName; // name of the table
    protected $columnNames = array(); // names of the columns in the data table
    protected $columnTypes = array(); // names of the types of each column
    protected $primaryKey; // the name of the primary key for the table

    // TODO 6/17/2022 -- attributes only needed for table creation, do we want this as a var here?

    /**
     * Constructor function to initalize a specific instance of a data table object.
     * The table must already be created, if it isn't call DataTableObject->createTable() 
     * to create the table.
     * 
     * @param string tableName          the name of the table to make the object off of
     * @param mysqli dbConnection       the connection to the database for this data table
     * @return DataTableObject obj      the data table object
     */
    // function __construct($tableName, $dbConnection) {
    //     /**
    //      * How to describe table with just data needed here
    //      * SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'Person';
    //      */
    // }

    function __construct($tableName, $colNames, $colTypes, $pri) {
        $this->tableName = $tableName;
        $this->columnNames = $colNames;
        $this->columnTypes = $colTypes;
        $this->primaryKey = $pri;
    }

    /**
     * Function to create the table that needs opened. If the ta
     * 
     * @param string tableName      - the name of the table
     * @param array columnInfo      - associative array of "columnName"=>"columnType" pairs
     * @param array columnAttr      - associative array of "columnName"=>"columnAttribute" pairs
     * @return boolean completed     - returns true if table has been created or false if the table already exists
     */
    static function createTable($tableName, $columnInfo, $columnAttr) {

    }

    /**
     * Function to insert a new row into the data table.
     * 
     * @param array info            an associative array of "colName"=>"colValue" pairs, where colName is 
     *                              the name of the column and colVal is the value to insert
     * @return boolean completed    returns true on success or false on failure
     */
    function insert($info) {
        $keys = array_keys($info);
        $types = "";
        $sql = "INSERT INTO {$this->tableName} (";

        foreach($keys as $key) {
            $sql += $key;

            if ($key != $keys[sizeof($keys) - 1]) {
                $sql += ", ";
            } //end if
        } // end fe

        $sql += ") VALUES (";

        for ($i = 0; $i < sizeof($info); $i++) {
            $sql += $info[$i];
            $curType = $this->columnTypes[$this->getColIndex($keys[$i])];
            settype($info[$i], $curType);

            if ($curType == "int") {
                $types += "i";
            } else {
                $types += "s";
            } //end if

            if ($i != (sizeof($info) - 1)) {
                $sql  += ", ";
            } //end if
        } // end for

        $sql += ");";

        return $sql;
        // $prep = $this->dbConnection->prepare($sql);
        // $prep->bind_param($types, ...$info);
        // if($prep->execute()) {
        //      return true;
        // } else {
        //      return false;
        // } //end if
    }

    /**
     * Function to insert multiple rows into the data table at once
     * 
     * @param array info            a multi-dimensional array where each index of the highest level array contains
     *                              an associative array of "colName"=>"colValue" pairs, where colName is 
     *                              the name of the column and colVal is the value to insert
     * @return boolean completed    returns true if all inserts succeed and false if even one fails
     */
    function multiInsert($info) {
        $completed = true;

        foreach ($info as $row) {
            if ($this->insert($row) === false) {
                $completed = false;
            } //end if
        } //end foreach

        return $completed;
    }

    /**
     * Function to update a row in the data table.
     * 
     * @param int   rowID           the specific ID for that row
     * @param array info            an associative array of "colName"=>"colValue" pairs, where colName is 
     *                              the name of the column and colVal is the value to update
     * @return boolean completed    returns true on success or false on failure
     */
    function update($rowID, $info) {
        // TODO 6/18/22 -- how to finish statement?
        $prep = $this->dbConnection->prepare("UPDATE {$this->tableName} SET ? = ? WHERE {$this->primaryKey} = ?");
    }

    /**
     * Function to select data from the database.
     * 
     * @param string|array what     a string(or array) denoting one (or more) column(s) to pull from the database
     * @param string where          the where clause during select
     * @return array selected       an associative array, where the key is the unique row id and the value
     *                              is another associative array of the format "colName"=>"colVal"
     *                              ex. [PID]=>("colName"=>"colVal", "colName2"=>"colVal2")
     */
    function select($what, $where) {
        $sql = "SELECT ";
        if (is_array($what)) {
            $lastCol = $what[sizeof($what) - 1];
            foreach($what as $column) {
                $sql += $column;

                if ($column != $lastCol) {
                    $sql += ", ";
                } //end if
            } //end fe
        } else {
            $sql += $what;
        } //end if

        $sql += " FROM {$this->tableName} WHERE ?";

        $prep = $this->dbConnection->prepare($sql);
        $prep->bind_param("s", $where);
        $prep->execute();
    }

    /**
     * Function to remove a row of data from the database.
     * 
     * @param string where          the where clause for which row to remove
     * @return boolean completed    returns true on success or false on failure
     */
    function delete($where) {
        // TODO 6/18/2022 -- TEST!! NO IDEA IF THIS IS HOW TO CODE THE PREPARED STATEMENTS
        $prep = $this->dbConnection->prepare("DELETE FROM {$this->tableName} WHERE ? LIMIT 1");
        $prep->bind_param("s", $where);
        $prep->execute();        
    }

    /**
     * Function to explicitly cast each data value from the data table to 
     * the type it should be.
     * 
     * @param array data            an associative array of colName=>colVal pairs representing the data
     *                              to be typed
     * @return array typedData      an associative array of colName=>colVal pairs with explicit types
     */
    protected function typeData($data) {
        $keys = array_keys($data); // the column names from the data array

        // loop through the data
        for ($i = 0; $i < sizeof($data); $i++) {
            $currIndex = $this->getColIndex($keys[$i]); // index of column name
            $type = $this->columnTypes[$currIndex]; // type the column is supposed to be
            settype($data[$i], $type);
        } //end for

        return $data;
    }

    /**
     * Function to get the index of a certain column in the data table
     * 
     * @param string name           the name of the column
     * @return int index            the index of that column in the arrays
     */
    protected function getColIndex($name) {
        for ($i = 0; $i < sizeof($this->columnNames); $i++) {
            if ($this->columnNames[$i] == $name) {
                return $i;
            } //end if
        } //end for

        return -1;
    }
}
?>