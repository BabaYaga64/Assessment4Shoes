<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $name = "Sketchers";
            $test_brand = new Brand($id, $name);

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals($test_brand, $result);
        }

        function test_getName()
        {
            //Arrange
            $id = 1;
            $name = "Doc Martens";
            $test_brand = new Brand($id, $name);

            //Act
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        //We test the setId because we are drawing that out of the db later in the code

        function test_setId()
        {
            //Arrange
            $id = 1;
            $name = "Dansko";
            $test_brand = new Brand($id, $name);

            //Act
            $test_brand->setId(2);

            //Assert
            $result = $test_brand->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $id = 1;
            $name = "Jellies";
            $test_brand = new Brand($id, $name);

            //Act
            $test_brand->save();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand], $result);
        }

        function test_getAll()
        {
            //Arrange
            $id = 1;
            $name = "Puma";
            $test_brand = new Brand($id, $name);

            $id2 = 2;
            $name2 = "Puma";
            $test_brand2 = new Brand($id2, $name2);

            //Act
            $test_brand->save();
            $test_brand2->save();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);

        }

        function test_deleteAll()
        {
            //Arrange
            $id = null;
            $name = "Spooky Shoes";
            $test_brand = new Brand($id, $name);

            $id2 = null;
            $name2 = "Crocs";
            $test_brand2 = new Brand($id2, $name2);

            $test_brand->save();
            $test_brand2->save();

            //Act
            Brand::deleteAll();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        //Finds a specific brand from the two that are saved
        function test_find()
        {
            //Assert
            $id = 1;
            $name = "Keen";
            $test_brand = new Brand($id, $name);

            $id2 = 1;
            $name2 = "Converse";
            $test_brand2 = new Brand($id2, $name2);

            $test_brand->save();
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand->getId());

            //Assert
            $this->assertEquals($test_brand, $result);
        }

        //find stores that carry a certain brand
        function test_getStores()
        {
            //Arrange
            $id = 1;
            $name = "Mary Janes";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $id2 = 3;
            $name2 = "Sole Food";
            $test_store = new Store($id2, $name2);
            $test_store->save();

            $id3 = 4;
            $name3 = "Happy Feet";
            $test_store2 = new Store($id3, $name3);
            $test_store2->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store, $test_store2], $result);

        }





























    }//Ends clasas
?>
