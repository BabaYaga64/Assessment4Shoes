<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');


    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $name = "Happy Feet";
            $test_store = new Store($id, $name);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(1, $result);


        }//Ends getId

        function test_getName()
        {
            //Arrange
            $id = 1;
            $name = "Footlocker";
            $test_store = new Store($id, $name);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($name, $result);

        }//Ends getName


        function test_setId()
        {
            //Arrange
            $id = 1;
            $name = "Happy Feet";
            $test_store = new Store($id, $name);

            //Act
            $test_store ->setId(2);

            //Assert
            $result = $test_store->getId();
            $this->assertEquals(2, $result);

        }

        function test_save()
        {
            //Arrange
            $id = 1;
            $name = "Footlocker";
            $test_store = new Store($id, $name);

            //Act
            $test_store->save();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store], $result);

        }

        function test_getAll()
        {
            //Arrange
            $id = null;
            $name = "Sole Food";
            $test_store = new Store($id, $name);

            $id2 = null;
            $name2 = "Happy Feet";
            $test_store2 = new Store($id2, $name2);

            //Act
            $test_store->save();
            $test_store2->save();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_getBrands()
        {
            //Arrange
            $id = 1;
            $name = "Abazaba";
            $test_store = new Store($id, $name);
            $test_store->save();

            $id2 = 2;
            $name = "Spooky Shoes";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $id3 = 3;
            $name2 = "Adidas";
            $test_brand2 = new Brand($id, $name);
            $test_brand2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand, $test_brand2], $result);




        }














    }//Ends class


?>
