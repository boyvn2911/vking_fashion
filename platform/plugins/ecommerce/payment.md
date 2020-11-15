# Table of Contents

* [Installation](#installation)
    * [Register new account](#register-new-account)
    * [Edit paypal client id and secret key](#edit-client-id-and-secret-key)
* [Code files](#code-files)
* [Resources](#resources)

# Installation

## Account Test

PayPal:
Client ID: AUNumgUbmupUkysS5eSYAOXFbTwDhmt8AMPJVG7sCrKJ6yEPldyW0eyM-Lkpbs8Y1mETGCp6ZYdeNmI6
Secret: EEoSMhON9ToesrnP-Vx_OEat3jMGUZUETOmb71K30U8a0c709bE8Y2NmnVHOseALDZK8FlPRgdhmjrNO

Stripe:

-Client ID: pk_test_7XJekDehXaxssmHNfkQMG4aG
- Secret: sk_test_4VVFUcuzMDBfSX84Il1Sj11c

## Register new account

Steps

* Register new account : https://developer.paypal.com
* Login to dashboard
* Create your app on PayPal: https://developer.paypal.com/developer/applications/

## Edit PayPal client id and secret key

Please go to `.env` file to edit client id and secret key. Default you can copy from .env.example file

* Please go to this place to get keys: https://developer.paypal.com/developer/applications/
* If you are in **local, dev or test environment**, please get keys in **SANDBOX MODE**
* If you are in **production environment**, please get keys in **LIVE MODE**
* Sample content are put in `.env.example` file.

## Test make a donation for GCE

Steps
* Open URL: http://your-domain.com/paypal
* Sandbox account for test: `test@botble.com` - `12345678`
* After made a charge, you can go to https://developer.paypal.com/developer/notifications/ to see the actual transaction.

# Code files

Related code files

* Setting
    * `.env` file : setting client id & secret key for SANDBOX MODE or LIVE MODE
    * `paypal.php` file

* PHP code
    * `Botble/Payment/Services/PayPalService.php` file

# Resources

List of resources which are nice to know when working with Stripe

* PayPal developer : https://developer.paypal.com

