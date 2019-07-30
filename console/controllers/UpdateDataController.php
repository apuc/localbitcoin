<?php
namespace console\controllers;

use common\models\Options;
use frontend\models\BitcoinUser;
use frontend\components\LocalBitcoinsWalletAPI;

class UpdateDataController extends \yii\console\Controller
{
    protected $LBV_API;

    public function init()
    {
        parent::init();
        $this->LBV_API = new LocalBitcoinsWalletAPI();
    }

    /**
     * Получение курса рубля
     */
    public function actionDollarRate(): void
    {
        $res = $this->LBV_API->equation('usd_in_rub');
        Options::setOption('usd_in_rub', $res->data);
    }

    /**
     * Получение максимального среднего курса доллара между www.bitfinex.com и www.bitstamp.net
     */
    public function actionMaxValue(): void
    {
        $bitstampusd_avg = $this->LBV_API->equation('bitstampusd_avg');
        $bitfinexusd_avg = $this->LBV_API->equation('bitfinexusd_avg');
        $usd_in_rub = $this->LBV_API->equation('usd_in_rub');

        Options::setOption('max_b', max($bitfinexusd_avg->data,
                $bitstampusd_avg->data) * $usd_in_rub->data);
    }

    /**
     * @throws \yii\console\Exception
     * Получение баланса кошелька
     */
    public function actionWalletValue(): void
    {
        $users = BitcoinUser::find()->all();
        foreach ($users as $user) {
            $Lbc_Wallet = new LocalBitcoinsWalletAPI($user->apikey,
                $user->secretkey);
            $res = $Lbc_Wallet->infos();
            if (isset($res->data)) {
                $user->balance = $res->data->total->balance;
                $user->save();
            }
        }
    }
}