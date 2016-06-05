<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    protected $baseUrl = 'http://localhost';
    // protected $baseUrl = 'http://localhost:8000';

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        // $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }


    public function prepareForTests()
    {
        // Mail::pretend(true);
    }

    public function setupDatabase()
    {
        // Artisan::call('migrate:reset');
        // Artisan::call('db:seed', array('--class'=>'TestingDatabaseSeeder'));
    }

    public function setUp()
    {
        parent::setUp();

        //reload session
        // \Laravel\Session::load();

        $this->prepareForTests();
          // View::addLocation(dirname(__DIR__).'/fixtures/views');
    }



    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }





    public function call($destination, $parameters = array(), $method = 'GET')
    {
        $old_method = Request::foundation()->getMethod();
        \Laravel\Request::foundation()->setMethod($method);
        $response = Controller::call($destination, $parameters);
        Request::foundation()->setMethod($old_method);
        return $response;
    }

    public function get($destination, $parameters = array())
    {
        return $this->call($destination, $parameters, 'GET');
    }


    public function post($destination, $post_data, $parameters = array())
    {
        $this->clean_request();
        \Laravel\Request::foundation()->request->add($post_data);
        return $this->call($destination, $parameters, 'POST');
    }

    private function clean_request()
    {
        $request = \Laravel\Request::foundation()->request;
        foreach ($request->keys() as $key)
        {
            $request->remove($key);
        }
    }
}


// ->assertResponseStatus($code);                                      = Assert that the client response has a given code.

// ->assertViewHas($key, $value = null);                               = Assert that the response view has a given piece of bound data.
// ->assertViewHasAll(array $bindings);                                = Assert that the view has a given list of bound data.
// ->assertViewMissing($key);                                          = Assert that the response view is missing a piece of bound data.

// ->assertRedirectedTo($uri, $with              = []);                = Assert whether the client was redirected to a given URI.
// ->assertRedirectedToRoute($name, $parameters  = [], $with = []);    = Assert whether the client was redirected to a given route.
// ->assertRedirectedToAction($name, $parameters = [], $with = []);    = Assert whether the client was redirected to a given action.

// ->assertSessionHas($key, $value               = null);              = Assert that the session has a given value.
// ->assertSessionHasAll(array $bindings);                             = Assert that the session has a given list of values.
// ->assertSessionHasErrors($bindings[], $format = null);              = Assert that the session has errors bound.
// ->assertHasOldInput();                                              = Assert that the session has old input.
















    // public function testSearchActionSite()
    // {
    //     $params = ['site' => 'unittest', 'resource' => 'product'];
    //     $params = ['site' => 'unittest', 'resource' => 'product', 'id' => '0'];
    //     $params = ['site' => 'invalid', 'resource' => 'product'];

    //     $response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@searchAction', $params);
    //     $response = $this->action('POST', '\Aimeos\Shop\Controller\JqadmController@saveAction', $params);
    //     $response = $this->action('GET', '\Aimeos\Shop\Controller\JqadmController@fileAction', ['site' => 'unittest', 'type' => 'css']);
    //     $response = $this->action('GET', '\Aimeos\Shop\Controller\AccountController@downloadAction', ['site' => 'unittest', 'dl_id' => 0]);
    //     $response = $this->action('GET', '\Aimeos\Shop\Controller\CheckoutController@updateAction', ['site' => 'unittest'], ['code' => 'paypalexpress']);


    //     $this->action('GET', '\Aimeos\Shop\Controller\PageController@termsAction', ['site' => 'unittest']);

    //     $this->assertEquals('', $response->getContent());
    //     $this->assertEquals( 200, $response->getStatusCode() );
    //     $this->assertEquals( 401, $response->getStatusCode() );
    //     $this->assertContains('.aimeos', $response->getContent());
    //     $this->assertContains('Aimeos = {', $response->getContent());
    //     $this->assertContains('Ext.', $response->getContent());
    //     $this->assertEquals( '302', $response->getStatusCode() );
    //     $this->assertRegexp('#{.*}#smu', $response->getContent());
    //     $this->assertRegexp('/[{.*}]/', $response->getContent());
    //     $this->assertRegexp('#<script type="text/javascript">.*window.MShop = {#smu', $response->getContent());

    //     // or
    //     $this->assertResponseOk();

    //     $this->assertContains('<section class="aimeos basket-related">', $response->getContent());
    //     $this->assertContains('.aimeos .product .stock', $response->getContent());




// $params = ['site' => 'invalid', 'resource' => 'product'];
//         $response = $this->action('OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );

//         $params = ['site' => 'unittest', 'resource' => 'product'];
//         $response = $this->action('OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertArrayHasKey( 'resources', $json['meta'] );
//         $this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );


//         $params = ['site' => 'unittest'];
//         $response = $this->action('OPTIONS', '\Aimeos\Shop\Controller\JsonadmController@optionsAction', $params);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertArrayHasKey( 'resources', $json['meta'] );
//         $this->assertGreaterThan( 1, count( $json['meta']['resources'] ) );

//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse'];
//         $content = '{"data":{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel","product.stock.warehouse.label":"laravel"}}}';
//         $response = $this->action('POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertEquals( 201, $response->getStatusCode() );
//         $this->assertNotNull( $json );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
//         $this->assertEquals( 'laravel', $json['data']['attributes']['product.stock.warehouse.code'] );
//         $this->assertEquals( 'laravel', $json['data']['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( 1, $json['meta']['total'] );

//         $id = $json['data']['attributes']['product.stock.warehouse.id'];


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
//         $content = '{"data":{"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel2","product.stock.warehouse.label":"laravel2"}}}';
//         $response = $this->action('PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertResponseOk();
//         $this->assertNotNull( $json );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
//         $this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.code'] );
//         $this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( $id, $json['data']['attributes']['product.stock.warehouse.id'] );
//         $this->assertEquals( 1, $json['meta']['total'] );


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
//         $response = $this->action('GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data']['attributes'] );
//         $this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.code'] );
//         $this->assertEquals( 'laravel2', $json['data']['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( $id, $json['data']['attributes']['product.stock.warehouse.id'] );
//         $this->assertEquals( 1, $json['meta']['total'] );


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse', 'id' => $id ];
//         $response = $this->action('DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params);

//         $json = json_decode( $response->getContent(), true );


//         $this->assertNotNull( $json );
//         $this->assertEquals( 1, $json['meta']['total'] );

//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse'];
//         $content = '{"data":[
//             {"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel","product.stock.warehouse.label":"laravel"}},
//             {"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel2","product.stock.warehouse.label":"laravel"}}
//         ]}';
//         $response = $this->action('POST', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertEquals( 201, $response->getStatusCode() );
//         $this->assertNotNull( $json );
//         $this->assertEquals( 2, count( $json['data'] ) );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][0]['attributes'] );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][1]['attributes'] );
//         $this->assertEquals( 'laravel', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( 'laravel', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( 2, $json['meta']['total'] );

//         $ids = array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $json['data'][1]['attributes']['product.stock.warehouse.id'] );


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
//         $content = '{"data":[
//             {"type":"product/stock/warehouse","id":' . $ids[0] . ',"attributes":{"product.stock.warehouse.label":"laravel2"}},
//             {"type":"product/stock/warehouse","id":' . $ids[1] . ',"attributes":{"product.stock.warehouse.label":"laravel2"}}
//         ]}';
//         $response = $this->action('PATCH', '\Aimeos\Shop\Controller\JsonadmController@patchAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertEquals( 2, count( $json['data'] ) );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][0]['attributes'] );
//         $this->assertArrayHasKey( 'product.stock.warehouse.id', $json['data'][1]['attributes'] );
//         $this->assertEquals( 'laravel2', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
//         $this->assertTrue( in_array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $ids ) );
//         $this->assertTrue( in_array( $json['data'][1]['attributes']['product.stock.warehouse.id'], $ids ) );
//         $this->assertEquals( 2, $json['meta']['total'] );


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
//         $getParams = ['filter' => ['&&' => [
//             ['=~' => ['product.stock.warehouse.code' => 'laravel']],
//             ['==' => ['product.stock.warehouse.label' => 'laravel2']]
//             ]],
//             'sort' => 'product.stock.warehouse.code', 'page' => ['offset' => 0, 'limit' => 3]
//         ];
//         $response = $this->action('GET', '\Aimeos\Shop\Controller\JsonadmController@getAction', $params, $getParams);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertEquals( 2, count( $json['data'] ) );
//         $this->assertEquals( 'laravel', $json['data'][0]['attributes']['product.stock.warehouse.code'] );
//         $this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.code'] );
//         $this->assertEquals( 'laravel2', $json['data'][0]['attributes']['product.stock.warehouse.label'] );
//         $this->assertEquals( 'laravel2', $json['data'][1]['attributes']['product.stock.warehouse.label'] );
//         $this->assertTrue( in_array( $json['data'][0]['attributes']['product.stock.warehouse.id'], $ids ) );
//         $this->assertTrue( in_array( $json['data'][1]['attributes']['product.stock.warehouse.id'], $ids ) );
//         $this->assertEquals( 2, $json['meta']['total'] );


//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse' ];
//         $content = '{"data":[
//             {"type":"product/stock/warehouse","id":' . $ids[0] . '},
//             {"type":"product/stock/warehouse","id":' . $ids[1] . '}
//         ]}';
//         $response = $this->action('DELETE', '\Aimeos\Shop\Controller\JsonadmController@deleteAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertNotNull( $json );
//         $this->assertEquals( 2, $json['meta']['total'] );

//         $params = ['site' => 'unittest', 'resource' => 'product/stock/warehouse'];
//         $content = '{"data":[
//             {"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel","product.stock.warehouse.label":"laravel"}},
//             {"type":"product/stock/warehouse","attributes":{"product.stock.warehouse.code":"laravel2","product.stock.warehouse.label":"laravel"}}
//         ]}';
//         $response = $this->action('PUT', '\Aimeos\Shop\Controller\JsonadmController@postAction', $params, [], [], [], [], $content);

//         $json = json_decode( $response->getContent(), true );

//         $this->assertEquals( 501, $response->getStatusCode() );
//         $this->assertNotNull( $json );
    // }