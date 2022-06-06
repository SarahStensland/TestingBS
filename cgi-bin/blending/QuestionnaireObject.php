<?php
    class QuestionnaireObject {
        protected $dataTables = array(0);

        function constructor() {
            $x=1;
        }    

        function setFormQueue($q) {
            $x = $q;
        }

        function addDataTable($table) {
            $this->dataTables += $table;
        }

        function saveAndQuit() {
            
        }
    }
?>