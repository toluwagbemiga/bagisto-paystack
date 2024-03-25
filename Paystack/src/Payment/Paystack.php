<?php

namespace Webkul\Paystack\Payment;

use Webkul\Payment\Payment\Payment;

class Paystack extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'paystack';

    protected $secretKey;
    protected $baseUrl;
    protected $authorizationUrl;

    /**
     * Get secret key from .env file
     */
    public function setKey()
    {
       return $this->secretKey = getenv('PAYSTACK_SECRET_KEY');
    }

    public function setBaseUrl()
    {
        return $this->baseUrl = getenv('PAYSTACK_PAYMENT_URL');
    }

    public function getRedirectUrl()
    {
        return route('paystack.redirect');
    }

    public function getFormFields()
    {
        $cart = $this->getCart();
        $billingAddress = $cart->billing_address;
        $total = $cart->sub_total + ($cart->selected_shipping_rate ? $cart->selected_shipping_rate->price : 0);
        $data = [
            'amount' => $total,
            'email' => $billingAddress->email,
            'reference' => $cart->id,
            '_token' => csrf_token(),
            'reference' => $this->getHashedToken(),
            'quantity' => 1,
            "currency" => (request()->currency != ""  ? request()->currency : "NGN")
        ];
        return $data;
    }

    public function pay()
    {
        $authBearer = 'Bearer '. $this->setKey();
        $cart = $this->getCart();
        $billingAddress = $cart->billing_address;
        $total = $cart->sub_total + ($cart->selected_shipping_rate ? $cart->selected_shipping_rate->price : 0);
        $curl = curl_init();
        

        $email= $billingAddress->email;
        $amount = $total*100;

        // url to go to after payment
        $callback_url = route('paystack.callback');  
        

        curl_setopt_array($curl, array(
            
            CURLOPT_URL => $this->setBaseUrl()."/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount'=>$amount,
                'email'=>$email,
                'callback_url' => $callback_url,
            // CURLOPT_SSL_VERIFYHOST => false,
            // CURLOPT_SSL_VERIFYPEER => false
        ]),
        CURLOPT_HTTPHEADER => [
            "authorization: ".$authBearer, //replace this with your own test key
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);
        
        if ($tranx === null || !isset($tranx['status'])) {
            // Handle the case where $tranx is null or 'status' key is not set
            return route('shop.checkout.cart.index');
        } else {
            dd($tranx);
            return $tranx['data']['authorization_url'];
        }
    }

    public function payCallback()
    {
        $authBearer = 'Bearer '. $this->setKey();
        
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
            die('No reference supplied');
        }

        curl_setopt_array($curl, array(
            CURLOPT_CAINFO => $certificate,
            CURLOPT_CAPATH => $certificate,
            CURLOPT_URL => $this->setBaseUrl()."/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: ".$authBearer,
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
            // there was an error from the API
            die('API returned error: ' . $tranx->message);
        }

        if('success' == $tranx->data->status){
            return true;
        }
    }
    
    /**
     * Get the pool to use based on the type of prefix hash
     * @param  string $type
     * @return string
     */
    private static function getPool($type = 'alnum')
    {
        switch ($type) {
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'hexdec':
                $pool = '0123456789abcdef';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
            case 'distinct':
                $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                break;
            default:
                $pool = (string) $type;
                break;
        }

        return $pool;
    }

    /**
     * Generate a random secure crypt figure
     * @param  integer $min
     * @param  integer $max
     * @return integer
     */
    private static function secureCrypt($min, $max)
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min; // not so random...
        }

        $log    = log($range, 2);
        $bytes  = (int) ($log / 8) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    /**
     * Finally, generate a hashed token
     * @param  integer $length
     * @return string
     */
    public static function getHashedToken($length = 25)
    {
        $token = "";
        $max   = strlen(static::getPool());
        for ($i = 0; $i < $length; $i++) {
            $token .= static::getPool()[static::secureCrypt(0, $max)];
        }

        return $token;
    }
}