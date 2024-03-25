<?php

namespace Webkul\Paystack\Http\Controllers;

use Webkul\Paystack\Payment\Paystack;
use Illuminate\Support\Facades\Redirect;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

class PaymentController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;
    public $paystack;

    public function __construct(
        OrderRepository $orderRepository,
        Paystack $paystack
    )
    {
        $this->paystack = $paystack;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Redirects to the paystack.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('paystack::paystack-redirect');
    }

    public function pay()
    {
        $url = $this->paystack->pay();
        return Redirect::to($url);
    }

    public function callback()
    {
        if($this->paystack->payCallback()){
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
        }
    }
}