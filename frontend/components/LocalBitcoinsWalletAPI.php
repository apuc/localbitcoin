<?php
namespace frontend\components;

use common\classes\Debug;

class LocalBitcoinsWalletAPI extends LocalBitcoins
{
    /**
     * @return LocalBitcoinsDto
     */
    public function infos(): LocalBitcoinsDto
    {
        return $this->query('/api/wallet/');
    }

    /**
     * @param string $value
     * @return LocalBitcoinsDto
     */
    public function equation(string $value): LocalBitcoinsDto
    {
        return $this->query('/api/equation/' . $value);
    }

    /**
     * @return object
     */
    public function balance(): object
    {
        return $this->query('/api/wallet-balance/');
    }

    /**
     * @param string $address
     * @param int $amount
     * @return object
     */
    public function send(string $address, int $amount): object
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount
        ));
    }

    /**
     * @param string $address
     * @param int $amount
     * @param int $pincode
     * @return object
     */
    public function sendPin(string $address, int $amount, int $pincode): object
    {
        return $this->query('/api/wallet-send/', array(
            'address' => $address,
            'amount' => $amount,
            'pincode' => $pincode
        ));
    }

    /**
     * @return object
     */
    public function addr(): object
    {
        return $this->query('/api/wallet-addr/');
    }
}