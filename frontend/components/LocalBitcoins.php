<?php
namespace frontend\components;

use yii\console\Exception;

class LocalBitcoins
{
    public function __construct($API_AUTH_KEY = null, $API_AUTH_SECRET = null)
    {
        $this->API_AUTH_KEY = $API_AUTH_KEY;
        $this->API_AUTH_SECRET = $API_AUTH_SECRET;
    }

    public function query(
        string $url,
        array $post = [],
        array $get = [],
        array $search = [],
        array $replace = []
    ): object {
        if (!defined('SSL_VERIFYPEER')) {
            define('SSL_VERIFYPEER', true);
        }
        if (!defined('SSL_VERIFYHOST')) {
            define('SSL_VERIFYHOST', true);
        }

        // Method
        $api_get = array(
            '/api/ads/',
            '/api/ad-get/{ad_id}/',
            '/api/ad-get/',
            '/api/payment_methods/',
            '/api/payment_methods/{countrycode}/',
            '/api/countrycodes/',
            '/api/currencies/',
            '/api/places/',
            '/api/contact_messages/{contact_id}/',
            '/api/contact_info/{contact_id}/',
            '/api/contact_info/',
            '/api/account_info/{username}',
            '/api/dashboard/',
            '/api/dashboard/released/',
            '/api/dashboard/canceled/',
            '/api/dashboard/closed/',
            '/api/myself/',
            '/api/notifications/',
            '/api/real_name_verifiers/{username}/',
            '/api/recent_messages/',
            '/api/wallet/',
            '/api/wallet-balance/',
            '/api/wallet-addr/',
            '/api/merchant/invoices/',
            '/api/merchant/invoice/{invoice_id}/'
        );
        $api_post = array(
            '/api/ad/{ad_id}/',
            '/api/ad-create/',
            '/api/ad-delete/{ad_id}/',
            '/api/feedback/{username}/',
            '/api/contact_release/{contact_id}/',
            '/api/contact_release_pin/{contact_id}/',
            '/api/contact_mark_as_paid/{contact_id}/',
            '/api/contact_message_post/{contact_id}/',
            '/api/contact_dispute/{contact_id}/',
            '/api/contact_cancel/{contact_id}/',
            '/api/contact_fund/{contact_id}',
            '/api/contact_mark_realname/{contact_id}/',
            '/api/contact_mark_identified/{contact_id}/',
            '/api/contact_create/{ad_id}/',
            '/api/logout/',
            '/api/notifications/mark_as_read/{notification_id}/',
            '/api/pincode/',
            '/api/wallet-send/',
            '/api/wallet-send-pin/',
            '/api/merchant/new_invoice/',
            '/api/merchant/delete_invoice/{invoice_id}/'
        );
        $api_public = array(
            '/buy-bitcoins-with-cash/{location_id}/{location_slug}/.json',
            '/sell-bitcoins-for-cash/{location_id}/{location_slug}/.json',
            '/buy-bitcoins-online/{countrycode:2}/{country_name}/{payment_method}/.json',
            '/buy-bitcoins-online/{countrycode:2}/{country_name}/.json',
            '/buy-bitcoins-online/{currency:3}/{payment_method}/.json',
            '/buy-bitcoins-online/{currency:3}/.json',
            '/buy-bitcoins-online/{payment_method}/.json',
            '/buy-bitcoins-online/.json',
            '/sell-bitcoins-online/{countrycode:2}/{country_name}/{payment_method}/.json',
            '/sell-bitcoins-online/{countrycode:2}/{country_name}/.json',
            '/sell-bitcoins-online/{currency:3}/{payment_method}/.json',
            '/sell-bitcoins-online/{currency:3}/.json',
            '/sell-bitcoins-online/{payment_method}/.json',
            '/sell-bitcoins-online/.json',
            '/bitcoinaverage/ticker-all-currencies/',
            '/bitcoincharts/{currency}/trades.json',
            '/bitcoincharts/{currency}/orderbook.json'
        );

        // Init curl
        static $ch = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/4.0 (compatible; LocalBitcoins API PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')');

        if (SSL_VERIFYPEER !== true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if (SSL_VERIFYHOST !== true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        // Build NONCE
        $mt = explode(' ', microtime());
        $API_AUTH_NONCE = $mt[1] . substr($mt[0], 2, 6);

        // Post ? Get ? Public ?
        $is_post = $is_get = $is_public = false;
        $datas = '';
        if (in_array($url, $api_post)) {
            if (!empty($post)) {
                $datas = http_build_query($post, '', '&');
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
            $is_post = true;
        } elseif (in_array($url, $api_get)) {
            if (!empty($get)) {
                $datas = http_build_query($get, '', '&');
            }
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            $is_get = true;
        } else {
            if (!empty($get)) {
                $datas = http_build_query($get, '', '&');
            }
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            $is_public = true;
        }

        // Something to replace in $url ?
        if (!empty($search)) {
            $url = str_replace($search, $replace, $url);
        }

        // Add Auth
        if (!$is_public) {
            $API_AUTH_SIGNATURE = strtoupper(hash_hmac('sha256',
                $API_AUTH_NONCE . ($this->API_AUTH_KEY) . $url . $datas, ($this->API_AUTH_SECRET)));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Apiauth-Key:' . ($this->API_AUTH_KEY),
                'Apiauth-Nonce:' . $API_AUTH_NONCE,
                'Apiauth-Signature:' . $API_AUTH_SIGNATURE
            ));
        }

        // Add Get params
        if (!$is_post && !empty($datas)) {
            $url .= '?' . $datas;
        }

        // Let's go!
        curl_setopt($ch, CURLOPT_URL, 'https://localbitcoins.com' . $url);
        $res = curl_exec($ch);

        // website/api error ?
        if (false === $res) {
            throw new Exception('Could not get reply: ' . curl_error($ch));
        }

        // return result
        return json_decode($res);
    }
}