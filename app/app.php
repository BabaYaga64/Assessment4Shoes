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

    // ADD A STORE AND VIEW ALL ITS BRANDS
    $app->get("/stores/{id}", function($id) use ($app)  {
        $current_store = Store::find($id);
        $current_store = $current_brand->getStores();
        return $app['twig']->render('stores.twig', array('store' => $current_store));
    });

    //ADD A BRAND AND VIEW ALL ITS STORES
        $app->get("/brands/{id}", function($id) use ($app) {
            $current_brand = Brand::find($id);
            $current_store = $current_brand->getStores();
            return $app['twig']->render('brands.twig', array('brand' => $current_brand, 'store' => $current_store));
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
