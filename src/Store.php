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

        function setName($new_name)
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

        function deleteStore()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

    //UPDATE
        function updateStore($new_store)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }


//JOIN STORES AND BRANDS

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO shoes_brands (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM
                stores JOIN shoes_brands ON (stores.id = shoes_brands.store_id)
                       JOIN brands ON (shoes_brands.brand_id = brands.id)
                       WHERE stores.id = {$this->getId()};");
            $brand_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach ($brand_ids as $brand) {
                $id = $brand['id'];
                $name = $brand['name'];
                $new_brand = new Brand($id, $name);
                array_push($brands, $new_brand);
            }
            return $brands;
        }


    }//Ends class

?>
