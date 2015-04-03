<?php

    class Brand
    {
        private $name;
        private $id;
        

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
            
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
            $this-> id = (int) $new_id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

    //DB FUNCTIONS

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                $brand_id = $brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $brand;
                }
            } return $found_brand;
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();

            foreach($returned_brands as $brand) {
                $id = $brand['id'];
                $name = $brand['name'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);

            } return $brands;
        }

        //DELETE ALL BRANDS
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }

        // (don't worry about building out updating, listing, or deleting for brands).

        //JOIN STORES AND BRANDS

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM
             brands JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                    JOIN stores ON (brands_stores.store_id = stores.id)
                    WHERE brands.id = {$this->getId()};");

            $store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach ($store_ids as $store) {
                $id = $store['id'];
                $name = $store['name'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);

            } return $stores;
        }

    }//Ends class

?>
