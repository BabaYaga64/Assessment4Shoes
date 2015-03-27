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
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES    ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            } return $found_store;
        }

        static function findName($search_name)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_name = $store->getName();
                if ($store_name == $search_name) {
                    $found_store = $store;
                }
            } return $found_store;

        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();

            foreach($returned_stores as $store) {
                $id = $store['id'];
                $name = $store['name'];
                $new_store = new Store($id, $name);
                array_push($stores, $new_store);

            } return $stores;
        }

        //DELETE
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }









//When a user is viewing a single store, list out all of the brands that have been added so far to that store and allow them to add a brand to that store. Create a method to get the brands sold at a store, and use a join statement in it.




    }//Ends class

?>
