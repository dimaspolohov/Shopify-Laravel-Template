<?php


use App\Http\Middleware\AuthPaymentRequest;
use App\Models\Payment;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Session;
use Illuminate\Contracts\Auth\Authenticatable;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;

class ShopifyService
{
    protected BasicShopifyAPI $api;

    public function __construct()
    {
        $options = new Options();
        $options->setVersion('2024-10');
        $this->api = new BasicShopifyAPI($options);
    }

    public function adminApi(): BasicShopifyAPI
    {
        return $this->api;
    }

    public function paymentApi(): BasicShopifyAPI
    {
        $this->api->removeMiddleware('request:auth')
                      ->addMiddleware(new AuthPaymentRequest($this->api), 'request:auth');

        return $this->api;
    }

    public function byStore(IShopModel|Authenticatable $store): ShopifyService
    {
        $this->api = $store->api();

        return $this;
    }

    public function byPayment(Payment $payment): ShopifyService
    {
        $this->api->setSession(new Session($payment->user->name, $payment->user->password));

        return $this;
    }
}
