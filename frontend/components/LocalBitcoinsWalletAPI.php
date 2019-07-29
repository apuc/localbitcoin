<?php
namespace frontend\components;

class LocalBitcoinsWalletAPI extends LocalBitcoins
{
    public function __construct($API_AUTH_KEY = null, $API_AUTH_SECRET = null)
    {
        $this->API_AUTH_KEY = $API_AUTH_KEY;
        $this->API_AUTH_SECRET = $API_AUTH_SECRET;
    }

    public function infos()
    {
        return $this->query('/api/wallet/');
    }

    public function equation($value)
    {
        return $this->query('/api/equation/' . $value);
    }

    public function balance()
    {
        return $this->query('/api/wallet-balance/');
    }

    public function send($address, $amount)
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount
        ));
    }

    public function sendPin($address, $amount, $pincode)
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount,
            'pincode' => $pincode
        ));
    }

    public function addr()
    {
        return $this->query('/api/wallet-addr/');
    }
}