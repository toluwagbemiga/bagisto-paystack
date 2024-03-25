# bagisto-paystack
This repository contains a paystack package for bagisto v2.0

# Bagisto Paystack Payment Gateway Package

This package integrates the Paystack payment gateway into Bagisto, allowing for seamless online payments.

## Installation

Follow these steps to install and configure the Paystack payment gateway package in Bagisto:

1. Clone the repository to your local machine:
git clone https://github.com/your-username/bagisto-paystack.git
2. Upload the package to your Bagisto project directory:
cp -r bagisto-paystack /path/to/bagisto/packages/webkul
3. Navigate to your Bagisto project directory:
cd /path/to/bagisto
4. Install the package dependencies using Composer:
composer install
5. in your composer.json add this code to it under 
autoload psr-4 array
`"Webkul\\Paystack\\": "packages/Webkul/Paystack/src",`
6. Register your service provider in the config/app.php file, also located in the Bagisto root directory:

<?php

return [
    // Other configuration options

    'providers' => ServiceProvider::defaultProviders()->merge([
        // Other service providers
        Webkul\Paystack\Providers\PaystackServiceProvider::class,
    ])->toArray(),
    
    // Other configuration options
];
7. After making these changes, run the following commands:

composer dump-autoload
php artisan config:cache


8. Configure your Paystack API keys in the `.env` file:
PAYSTACK_SECRET_KEY=secretkey
PAYSTACK_PAYMENT_URL=https://api.paystack.co
MERCHANT_EMAIL=


11. You're all set! Log in to your Bagisto admin panel and configure the Paystack payment gateway under the Payment Methods section.

## Support

If you encounter any issues or have questions, feel free to reach out to us at redconetech@gmail.com.

## Contributing

We welcome contributions to improve this package. Fork the repository, make your changes, and submit a pull request.

Happy selling with Paystack on Bagisto!
