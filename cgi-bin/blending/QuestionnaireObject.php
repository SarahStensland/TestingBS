<?php
/**
 * Placeholder questionnaire object.
 * The classes here are classes we may or may not want or need for the questionnaire object
 * 
 * addDataTable is from when I was assuming the data tables would be associative arrays linked with the questionnaire object
 *      - currently they're their own object so this is possible irrelevant
 */
class QuestionnaireObject {
    protected $dataTables = array(0);
    protected $formQueue = array();

    function __construct() {
        $x=1;
    }    

    function setFormQueue($q) {
        $x = $q;
    }

    function addDataTable($table) {
        $this->dataTables += $table;
    }

    function saveAndQuit() {
        // this function should ensure the questionnaire object and all it's contingencies are properly saved
        // data should be saved already so this is specifically anything pertaining to the questionnaire object and the data table objects 
        //      - depending on how the data table objects are set up
    }
}
?>