<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');


    class StoreTest extends PHPUnit_Framework_TestCase
    {
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

        // function test_save()
        // {
        //     //Arrange
        //     $id = 1;
        //     $name = "Footlocker";
        //     $test_store = new Store($id, $name);
        //
        // }







    }//Ends class


?>
