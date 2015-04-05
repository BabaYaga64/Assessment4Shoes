<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Home Page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    //View all stores
    //READ
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll()));
    });


    //View all brands
    //READ
    //(don't worry about building out updating, listing, or deleting for brands).
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });

    //View a single store
    //READ
    $app->get("/stores", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //View a single brand
    //READ
    $app->get("/brands", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    //Add a single store (using form in stores.twig)
    //CREATE
    $app->post("/stores", function() use ($app) {
        $name = $_POST['name'];
        $store = new Store($name);
        $store->save();
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll()));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //Add a single brand (using form in brands.twig)
    //CREATE
    $app->post("/brands", function() use ($app) {
        $name = $_POST['name'];
        $brand = new Brand($_POST['name']);
        $brand->save();
        return $app['twig']->render('a_brand.twig', array('brands' => Brand::getAll()));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });


    //Add a store to a brand
    //CREATE
    $app->post("/add_stores", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'brands' => Brand::getAll(), 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    $app->post("brands/add_stores", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'brands' => Brand::getAll(), 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    //Add a brand to a store
    //CREATE
    $app->post("/add_brands", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $store->addBrand($brand);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'stores' =>Store::getAll(), 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    $app->post("/stores/add_brands", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $store->addBrand($brand);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'stores' =>Store::getAll(), 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //Edit a store name
    //UPDATE
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.twig', array('store' => $store));
    });

    $app->patch("/stores/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $store = Store::find($id);
        $store->update($name);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands()));
    });

    //Delete all stores
    $app->delete("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.twig');
    });

    //Delete a single store
    //DELETE
    $app->delete("/delete_stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.twig', array('stores' => $stores));
    });

    //Delete all brands
    //DELETE
    $app->delete("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.twig');
    });

    return $app;

?>
