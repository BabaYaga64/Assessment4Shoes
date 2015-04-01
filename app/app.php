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

    //MAIN PAGE
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');

    });


    //SHOW ALL STORES
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll()));
    });

    //SHOW A SINGLE STORE
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('a_store.twig', array('store' => $store, 'stores' => $brand->getStores(), 'stores' => Store::getAll()));
    });

    // ADD A STORE AND VIEW ALL ITS BRANDS
    $app->get("/stores/{id}", function($id) use ($app)  {
        $current_store = Store::find($id);
        $current_store = $current_brand->getStores();
        return $app['twig']->render('stores.twig', array('store' => $current_store));
    });

    $app->post("/stores", function() use ($app) {
        $new_store = new Store($_POST['id'], $_POST['name']);
        $new_store->save();
        return $app['twig']->render('stores.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    //SHOW ALL BRANDS
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });

    //SHOW A SINGLE BRAND
    $app->get("/brands/{id}", function($id) use ($app) {
        $current_brand = Brand::find($id);
        $current_store = $current_brand->getStores();
        return $app['twig']->render('brands.twig', array('brand' => $current_brand));
    });

    //ADD A BRAND AND VIEW ALL ITS STORES
        $app->get("/brands/{id}", function($id) use ($app) {
            $current_brand = Brand::find($id);
            $current_store = $current_brand->getStores();
            return $app['twig']->render('brands.twig', array('brand' => $current_brand, 'store' => $current_store));
        });

    $app->post("/brands", function() use ($app) {
        $new_brand = new Brand($_POST['id'], $_POST['name']);
        $new_brand->save();
        $new_store = new Store($_POST['id'], $_POST['name']);
        $new_store->save();
        $new_brand->addStore($new_store);

        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));


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
