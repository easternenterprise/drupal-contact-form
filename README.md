# how to include this module in drupal project ?

configure repository settings as below
```
    "repositories": [
        {
            "type": "composer",
            "url": "https://packages.drupal.org/8"
        },
        {
            "type": "package",
            "package": {
                "name": "shivanandmitakari/contact_form",
                "version": "dev-master",
                "type":"drupal-custom-module",
                "source": {
                    "url": "git@git.easternenterprise.com:shivanandmitakari/contact_form.git",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
    ],
```

use below command to include this module

```
composer require shivanandmitakari/contact_form
```

# List of pages avaiable with this module.
1. Contact form page : Contact form will appear on this URL.
```
    /contact_form/details
```
2. Contact form setting page : This shows all list of fields in the form and fields can me hidden using configuraion provided here.
```
    /contact_form/details
```
3. Thanks you page : Once user fills the form, user will be redirected to this thank you page.
```
    /contact_form/details/thankyou
```
4. Contact list in JSON: All contact form submissions will be avaiable on this url.
```
    /contact_form/get-contacts-json
```
