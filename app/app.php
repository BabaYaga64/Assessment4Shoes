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
        return $app['twig']->render('index.twig');
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
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'brands' => $store->getBrands(), 'brands' => Brand::getAll()));
    });

    //View a single brand
    //READ
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('a_brand.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    //Add a single store (using form in stores.twig)
    //CREATE
    $app->post("/stores", function() use ($app) {
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll()));
    });

    //Add a single brand
    //CREATE
    $app->post("/brands", function() use ($app) {
        $name = $_POST['name'];
        $new_brand = new Brand($name);
        $new_brand->save();
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));    
    });


    //Add a store to a brand
    //CREATE
    $app->post("add_store", function() use ($app) {
        $brand = Brand::find($id);
        $store = $_POST['store'];
        $add_new_store = new Store($store);
        $add_new_store->save();
        $brand->addStore($add_new_store);
        $stores = $brand->getStores();
        return $app['twig']->render('a_brand.twig', array('stores' => $stores, 'brand' => $brand));
    });

    //Add a brand to a store
    //CREATE
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
