<?php
namespace console\controllers;

use common\classes\Debug;
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

    public function actionDollarRate()
    {
        $res = $this->LBV_API->equation('usd_in_rub');
        Options::setOption('usd_in_rub', $res->data);

        return $res->data;
    }

    public function actionMaxValue()
    {
        $bitstampusd_avg = $this->LBV_API->equation('bitstampusd_avg');
        $bitfinexusd_avg = $this->LBV_API->equation('bitfinexusd_avg');
        $usd_in_rub = $this->LBV_API->equation('usd_in_rub');

        Options::setOption('max_b', max($bitfinexusd_avg->data,
                $bitstampusd_avg->data) * $usd_in_rub->data);
    }

    public function actionWalletValue()
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