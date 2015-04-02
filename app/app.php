<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //Home Page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });

    //View all stores
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll()));
    });

    $app->post("/stores", function() use ($app) {
    $new_store = new Store($_POST['id'], $_POST['name']);
    $new_store->save();
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    //View all brands
    //(don't worry about building out updating, listing, or deleting for brands).
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });

    $app->post("/brands", function() use ($app) {
    $new_brand = new Brand($_POST['id'], $_POST['name']);
    $new_brand->save();
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });

    //View a single store
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //View a single brand
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    //Add a store to a brand
    $app->post("add_store", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'brands' => Brand::getAll(), 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    //Add a brand to a store
    $app->post("add_brand", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'stores' => Store::getAll(), 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //Edit a store name
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.twig', array('store' => $store));
    });

    $app->patch("/stores/{id}/update", function($id) use ($app) {
        $store = Store::find($id);
        $new_name = $_POST['new_name'];
        $store->updateStore($new_name);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //DELETE ALL STORES
    $app->delete("delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.twig');
    });


    //DELETE ALL BRANDS
    $app->delete("delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.twig');
    });

    return $app;


?>
