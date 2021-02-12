# Password Policy

![](password_policy.png)

----

OXID module for additional password validation, strength visualization and expiry rules.

# Professional Support

Do you or does your client need this module in a stable and reliable environment?
Then request your professional support right now.

Contact us for a support contract that fit to your needs and may include things like:

- feature implementation
- free updates
- installation support
- bug fixes

Please contact professional-services@oxid-esales.com to get an offer.


## Installation

1. `composer require oxid-professional-services/password-policy`
1. `composer update`
1. Add missing blocks to your templates. See https://github.com/OXID-eSales/flow_theme/pull/154/files
1. Activate module it in admin area or call `vendor/bin/oe-console oe:module:activate oxpspasswordpolicy [--shop-id=<The Shop ID>]`

## Usage

In the admin area, go to Administer Users -> Password Policy and adjust default settings to:
 * Set preferred password strength requirements
 * Set account block options on bad password attempts
