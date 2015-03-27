<?php

    class Store
    {
        private $id;
        private $name;


        function __construct($id = null, $name)
        {
            $this->id = $id;
            $this->name = $name;

        }

        //GETTERS

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        //SETTERS

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function setName()
        {
            $this->name = (string) $new_name;
        }

        //DB FUNCTIONS





    }//Ends class

?>
