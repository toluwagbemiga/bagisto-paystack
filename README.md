# bagisto-paystack
This repository contains a paystack package for bagisto v2.0

# Bagisto Paystack Payment Gateway Package

This package integrates the Paystack payment gateway into Bagisto, allowing for seamless online payments.

## Installation

## Please give me a star if you love this project and it worked for you

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
6. Register your service provider in the config/app.php file, also located in the Bagisto root directory: <br>


		<?php
			return [
        		// Other configuration options 
        		'providers' => ServiceProvider::defaultProviders()->merge([
            		// Other service providers
		 	Webkul\Paystack\Providers\PaystackServiceProvider::class,
		        ])->toArray(),
		        // Other configuration options
    	];
7. In the config/bagisto-vite.php file, add the following line under the ‘viters’ section:




	    'paystack' => [
	        'hot_file'                 => 'paystack-vite.hot',
	        'build_directory'          => 'themes/paystack/build',
	        'package_assets_directory' => 'src/Resources/assets',
	    ],
	    

8. Go to `app/Http/Middleware/VerifyCsrfToken.php` file and add the following line under
`‘$except’` variables.

		protected $except = [
    		'checkout/cyber-paystack/*',
		];
After making these changes, run the following commands:<br>

	composer dump-autoload
	php artisan config:cache


8. Configure your Paystack API keys in the `.env` file: <br>
```
PAYSTACK_SECRET_KEY=secretkey
PAYSTACK_PAYMENT_URL=https://api.paystack.co 
MERCHANT_EMAIL=
```

11. You\`re all set! Log in to your Bagisto admin panel and configure the Paystack payment gateway under the Payment Methods section.<br>
<br>
## Support<br>
<br>
If you encounter any issues or have questions, feel free to reach out to us at redconetech@gmail.com.<br>
<br>
## Contributing<br>
<br>
We welcome contributions to improve this package. Fork the repository, make your changes, and submit a pull request.<br>
<br>
Happy selling with Paystack on Bagisto!<br>
