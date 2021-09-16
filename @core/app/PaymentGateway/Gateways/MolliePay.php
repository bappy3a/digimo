<?php


namespace App\PaymentGateway\Gateways;

use App\PaymentGateway\PaymentGatewayBase;
use Mollie\Laravel\Facades\Mollie;

class MolliePay extends PaymentGatewayBase
{
    /**
     * to work this payment gateway you must have this laravel package
     * https://github.com/mollie/laravel-mollie
     * */
    /**
     * @since 1.0.0
     * return how them amount need to change
     * */
    public function charge_amount($amount)
    {
        // TODO: Implement charge_amount() method.
        if (in_array(self::global_currency(), $this->supported_currency_list())){
            return $amount;
        }
        return self::get_amount_in_usd($amount);
    }

    /**
     * @param array $args
     * @return array|string[]
     * @since 1.0.0
     * handle payment gateway ipn response
     */
    public function ipn_response(array $args = [])
    {
        // TODO: Implement ipn_response() method.
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');

        if ($payment->isPaid()) {
            return $this->verified_data([
                'status' => 'complete',
                'transaction_id' => $payment->id,
                'order_id' => $payment->metadata->order_id
            ]);
        }
        return ['status' => 'failed'];
    }

    /**
     * @since 1.0.0
     * charge customer account by this method
     * @required param list
     * amount
     * description
     * web_hook
     * order_id
     * track
     * */
    public function charge_customer(array $args)
    {
        // TODO: Implement charge_customer() method.
        $charge_amount = $this->charge_amount($args['amount']);
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => $this->charge_currency(),
                "value" => number_format((float) $this->charge_amount($charge_amount), 2, '.', ''),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => $args['description'],
            "redirectUrl" => $args['web_hook'],
            "metadata" => [
                "order_id" => $args['order_id'],
                "track" => $args['track'],
            ],
        ]);

        $payment = Mollie::api()->payments->get($payment->id);

        session()->put('mollie_payment_id', $payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    /**
     * @since 1.0.0
     * list of all supported currency by payment gateway
     * */
    public function supported_currency_list()
    {
        // TODO: Implement supported_currency_list() method.
        return ['AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR'];
    }

    /**
     * charge_currency()
     * @since 1.0.0
     * get charge currency for payment gateway
     * */
    public function charge_currency()
    {
        // TODO: Implement charge_currency() method.
        if (in_array(self::global_currency(), $this->supported_currency_list())) {
            return self::global_currency();
        }
        return "USD";
    }

    /**
     * geteway_name()
     * @since 1.0.0
     * add payment gateway name
     * */
    public function gateway_name()
    {
        // TODO: Implement geteway_name() method.
        return 'mollie';
    }
}