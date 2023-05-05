# PHP Laravel 9 Shopify App

Boilerplate code for a [Shopify Custom App](https://help.shopify.com/en/manual/apps/app-types#custom-apps) therefore this App doesnt contain any OAuth flow.

## System Requirements

PHP 8.0 or above

Composer 2.x or above

ngrok 3.x or above

## Development Installation & Set-up

Create the environment file. Copy `.env.example` to `.env`. Edit `SHOPIFY_SHOP_NAME` and `SHOPIFY_ACCESS_TOKEN` in `.env`

Create the application key

`$ php artisan key:generate`

### Node.js

Node.js version managed via [Node Version Manager](https://github.com/nvm-sh/nvm#installing-and-updating) or [ASDF](https://asdf-vm.com/guide/getting-started.html)

To install and use the correct version of Node.js, run the following command from the project folder:

`$ nvm i`

-or-

`$ asdf install`

## Install project dependencies

`$ composer install`
`$ npm install`

## Build the project

`$ npm run build`

## Serve the application

Sign up for [ngrok](https://ngrok.com) so we can proxy a public domain to our localhost.

Install the ngrok binary and then add your auth token (if not already installed):

`$ ngrok config add-authtoken <your token>`

Start the local webserver:

`$ php artisan serve --host=127.0.0.1 --port=8080`

Proxy the application with ngrok, using the relevant host and port:

`$ ngrok http 127.0.0.1:8080`

## Hot reloading client-side code

To run with hot-reloading:

`$ npm run dev`
