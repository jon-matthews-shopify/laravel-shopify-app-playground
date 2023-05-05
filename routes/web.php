<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ShopifyGraphQLAdminApi;

Route::get('/', function () {
    die('Shopify Laravel App');
});

Route::get('/customer_update', function () {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-07');

    $query = 'mutation customerUpdate {
        customerUpdate(input: {
            id: "gid://shopify/Customer/6673225613624",
            firstName: "Jonny",
            lastName: "M"
            locale: "fr"
        }) {
          customer {
            firstName
            lastName
            email
            locale
          }
          userErrors {
            field
            message
          }
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/customer_create', function () {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-07');

    $query = 'mutation customerCreate {
        customerCreate(input: {
            locale: "testing"
            firstName: "Jimmy"
            lastName: "5"
            email: "jimmy+5@example.com"
        }) {
          customer {
            firstName
            email
            locale
          }
          userErrors {
            field
            message
          }
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/customer_get', function () {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2023-01');

    $query = '
    query {
        customer(id: "gid://shopify/Customer/6673225613624") {
          id
          firstName
          lastName
          locale
          acceptsMarketing
          email
          phone
          averageOrderAmountV2 {
            amount
            currencyCode
          }
          createdAt
          updatedAt
          note
          verifiedEmail
          validEmailAddress
          tags
          lifetimeDuration
          defaultAddress {
            formattedArea
            address1
          }
          addresses {
            address1
          }
          image {
            src
          }
          canDelete
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/product_create', function () {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-07');

    $query = 'mutation productCreate {
        productCreate(input: {
            title: "my gql product"
            images: [{
                src: "https://cdn.shopify.com/assets/images/logos/shopify-bag.png"
            }]
            metafields:[{
                namespace: "custom"
                key: "ingredients"
                value: "oat milk,\nsugar,\nchia seeds"
                type: "multi_line_text_field"
            }]
        }) {
          product {
            id
            title
            metafields(first: 5) {
                edges {
                  node {
                    key
                    value
                  }
                }
            }
          }
          userErrors {
            field
            message
          }
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);

    //return view('welcome');
});

Route::get('/product_create2', function () {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    'unstable');

    $query = 'mutation productCreate {
        productCreate(input: {
            title: "A Test product",
            descriptionHtml: "<strong>Test product</strong>",
            status: ACTIVE,
            handle: "",
            options: [
                "color",
                "size"
            ],
            customProductType: "2023-01-14T19:45:02.534Z",
            variants: [
                {
                    options: [
                        "Blue",
                        "Age 6 Years"
                    ],
                    sku: "BC_6",
                    title: "Blue coat",
                    price: "10",
                    taxable: false,
                    inventoryManagement: SHOPIFY,
                    inventoryQuantities: {
                        availableQuantity: 0,
                        locationId: "gid://shopify/Location/65693909014"
                    },
                    position: 2
                },
                {
                    options: [
                        "Blue",
                        "Age 7 Years"
                    ],
                    sku: "BC_7",
                    title: "Blue coat",
                    price: "12",
                    taxable: false,
                    inventoryManagement: SHOPIFY,
                    inventoryQuantities: {
                        availableQuantity: 0,
                        locationId: "gid://shopify/Location/65693909014"
                    },
                    position: 1
                },
            ],
            images: [
                {
                    src: "https://images.unsplash.com/photo-1519966776149-927c0270b1d4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGJsdWUlMjBjb2F0fGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=800&q=60",
                    altText: "Blue coat 6 years"
                },
                {
                    src: "https://plus.unsplash.com/premium_photo-1663133930245-a7f24d9fef6c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fGJsdWUlMjBjb2F0fGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=800&q=60",
                    altText: "Blue coat 7 years"
                }
            ],
            tags: [
                "Coats",
                "Boys",
            ],
            published: true,
            id: "gid://shopify/Product/8067613262127"
        }) {
            product {
              id
              title
            }
            userErrors {
              field
              message
            }
          }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);

    //return view('welcome');
});

Route::get('/import_order', function () {

    // 41 USD = 37.37GBP
    $orderPayload = [
        'order' => [
            "currency" => "GBP",
            "presentment_currency" => "GBP",
            'customer' => [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'currency' => 'GBP',
            ],
            'customer_locale' => 'en-GB',
            'line_items' => [
                [
                    'variant_id' => 42200999755798,
                    'quantity' => 1,
                    'price' => 37.00,
                    'price_set' => [
                        'shop_money' => [
                            'amount' => 41.00,
                            'currency_code' => 'USD',
                        ],
                        'presentment_money' => [
                            'amount' => 37.37,
                            'currency_code' => 'GBP',
                        ],
                    ],
                ],
                [
                    'variant_id' => 42200997167126,
                    'quantity' => 1,
                    'price' => 50.97,
                    'price_set' => [
                        'shop_money' => [
                            'amount' => 55.55,
                            'currency_code' => 'USD',
                        ],
                        'presentment_money' => [
                            'amount' => 50.97,
                            'currency_code' => 'GBP',
                        ],
                    ],
                ],
            ],
        ],
    ];

    $api = new App\Models\ShopifyRestAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-07');

    $response = $api->post('/orders.json', $orderPayload)->getBody();

    echo '<pre>';
    print_r($response);
    echo '</pre>';

    //$orderID = $response['order']['id']

    //return view('welcome');
});

Route::get('/order_create', function () {

    $query = '
    mutation draftOrderCreate() {
        draftOrderCreate(input: {

        }) {
          draftOrder {
            # DraftOrder fields
          }
          userErrors {
            field
            message
          }
        }
      }
    ';

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-10');

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/order_refund_2', function () {

    $query = 'mutation refundCreate {
        refundCreate(input: {
            orderId: "gid://shopify/Order/5234377031992",
            notify: true,
            refundLineItems: [
              {
                lineItemId: "gid://shopify/LineItem/13712221241656",
                locationId: "gid://shopify/Location/73448423736",
                quantity: 1,
                restockType: RETURN
              }
            ],
            shipping: {
              amount: "0.0",
              fullRefund: true
            },
            transactions: [
              {
                amount: "9.41",
                gateway: "shopify_payments",
                kind: REFUND,
                orderId: "gid://shopify/Order/5234377031992",
                parentId: "gid://shopify/OrderTransaction/6401221230904"
              }
            ]
          }) {
            order {
                id
              }
              refund {
                id
              }
              userErrors {
                field
                message
              }
          }
      }
    ';

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-10');

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/order_refund', function () {

    $query = 'mutation refundCreate {
        refundCreate(input: {
            orderId: "gid://shopify/Order/5234377031992",
            notify: true,
            refundLineItems: [
              {
                lineItemId: "gid://shopify/LineItem/13712221241656",
                locationId: "gid://shopify/Location/73448423736",
                quantity: 1,
                restockType: RETURN
              }
            ],
            shipping: {
              amount: "0.0",
              fullRefund: true
            },
            transactions: [
              {
                amount: "9.41",
                gateway: "shopify_payments",
                kind: REFUND,
                orderId: "gid://shopify/Order/5234377031992",
                parentId: "gid://shopify/OrderTransaction/6401221230904"
              }
            ]
          }) {
            order {
                id
              }
              refund {
                id
              }
              userErrors {
                field
                message
              }
          }
      }
    ';

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-10');

    $response = $api->request($query)->getBody();

    return response()->json($response);

});

Route::get('/bulk_product_import', function (Request $request) {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
    config('shopify.shop_name'),
    '2022-07');

    $contents = Storage::disk('local')->get('bulk_product_file.json');

    dd($contents);

    echo 'run';
    exit();
});

Route::get('/gql_bulk', function (Request $request) {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-10');

    $query = 'query {
        currentBulkOperation(type: QUERY) {
          id
          type
          status
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);
});

Route::get('/gql_testing', function (Request $request) {

    $api = new App\Models\ShopifyGraphQLAdminApi(config('shopify.access_token'),
                                                    config('shopify.shop_name'),
                                                    '2022-10');

    $query = 'query {
        currentBulkOperation(type: QUERY) {
          id
          type
          status
        }
      }
    ';

    $response = $api->request($query)->getBody();

    return response()->json($response);
});
