<?php
namespace frontend\components;

use common\classes\Debug;

class LocalBitcoinsWalletAPI extends LocalBitcoins
{
    public function __construct($API_AUTH_KEY = null, $API_AUTH_SECRET = null)
    {
        $this->API_AUTH_KEY = $API_AUTH_KEY;
        $this->API_AUTH_SECRET = $API_AUTH_SECRET;
    }

    public function infos(): object
    {
        return $this->query('/api/wallet/');
    }

    public function equation(string $value): object
    {
        return $this->query('/api/equation/' . $value);
    }

    public function balance(): object
    {
        return $this->query('/api/wallet-balance/');
    }


    public function send(string $address, int $amount): object
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount
        ));
    }

    public function sendPin(string $address, int $amount, int $pincode): object
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount,
            'pincode' => $pincode
        ));
    }

    public function addr(): object
    {
        return $this->query('/api/wallet-addr/');
    }
}