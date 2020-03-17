ServicesBundle
=============

This bundle implements an oauth2 authentication with Google.

Note
----

The bundle is under heavy development and should not be used at this time.

Documentation
-------------

This bundle is integrated with Guard and verify if the user is logged in. If is not logged call Goggle via oauth2 to make authentication. 
The authorization process is under development and is dependent from host application.


Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require retitalia/authentication-bundle
```

If an error is returned regarding the oauth2 library that can not be installed, this is due to a problem with the bundle paragonie. 
In this case, give this command 

```console
$ composer require paragonie/random_compat 2.0.17
```

and then repeat the bundle installation procedure


This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new retItalia\AuthenticationBundle\retItaliaAuthenticationBundle(),
            new KnpU\OAuth2ClientBundle\KnpUOAuth2ClientBundle(),
        );

        // ...
    }

    // ...
}
```


In app/config/security.yml add


under firewalls:, at the same heigth of dev:

```php
	main:
            anonymous: ~
            logout:
              path:   /logout
              target: /
            guard:
              authenticators:
                - authenticator
```

```php
	providers:
		dbal:
		  entity:
		      class: retItaliaAuthenticationBundle:SaUtente
		      property: idUtente
```

```php
	providers:
		dbal:
		  entity:
		      class: retItaliaAuthenticationBundle:SaUtente
		      property: idUtente
```

```php
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/authentication, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/non-autorizzato, roles: IS_AUTHENTICATED_ANONYMOUSLY }
```

It's good thing to add roles like this:
```php
        role_hierarchy:
            ROLE_ADMIN:       ROLE_USER
            ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
```

In app/config/routing.yml add
```php
	ret_italia_authentication:
	    resource: "@retItaliaAuthenticationBundle/Controller/"
	    type:     annotation
	    prefix:   /
```

In app/config/config.yml add the configuration:
```php

//..
twig:
    debug: '%kernel.debug%'
    strict_variables: '%kernel.debug%'
    globals:
        # the value is the service's id
//..
        userAuthorizedFunctions: "@userAuthorizedFunctions"
//..
//..
# Doctrine Configuration
doctrine:
    dbal:
        connections:
            bdc:
                driver: '%bdc_driver%'
                host: '%bdc_host%'
                port: '%bdc_port%'
                dbname: '%bdc_name%'
                user: '%bdc_user%'
                password: '%bdc_password%'
                charset: UTF8
//..	
knpu_oauth2_client:
    clients:
      # will create service: "knpu.oauth2.client.google"
      # an instance of: KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient
      # composer require league/oauth2-google
      google_main:
          type: google
          # add and configure client_id and client_secret in parameters.yml
          client_id: '%google_client_id%'
          client_secret: '%google_client_secret%'
          # a route name you'll create
          redirect_route: '%google_redirect_url%'
          redirect_params: {}

ret_italia_authentication:
    parameters:
        google_client_id: '%google_client_id%'
        google_client_secret: '%google_client_secret%'
        google_redirect_url: '%google_redirect_url%'
	application_id: '%application_id%'
```

In app/config/parameters.yml add:
```php
parameters:
    bdc_host: <bdc server>
    bdc_port: <bdc port>
    bdc_name: <bdc name>
    bdc_user: <bdc user>
    bdc_password: <bdc password>
    bdc_driver: oci8
//..
    google_client_id: '<google_client_id>'
    google_client_secret: '<google_client_secret>'
    google_redirect_url: '<google_redirect_url>'
    application_id: <application_id>
```

Per gli ambienti di test e develop google_redirect_url deve essere uguale a 'connect_google_check'
Per parameters.yml, perciò per l'ambiente di produzione locale, google_redirect_url='connect_google_check_dev'

In app/config/parameters.yml you must also add the application that must be authorized for google authentication:
```php
scope_auth: ['<application-1>','<application-2>']
```

if you don't know which application you must use, you can left the parameter empty:
```php
scope_auth: []
```

The correct values for parameters can be get from
https://gitlab.com/retitalia/contenitore-bundle-comuni

License
-------

This bundle is under the MIT license.


Usage
============


The authentication is automatic, it calls via oauth2 google sso and perform the process.

The authorization is based on specific database. The user must be enabled in correct table and must have a role for specified application.

It test the application specified in parameters.yml via application_id parameter.

There are however others useful functions that can be called manually.

Test specified function
-------

To test if the logged user has the abilitation for a specified function is sufficient to call the isFunctionAuthorized in this way:

```php
if ($this->get('userAuthorizedFunctions')->isFunctionAuthorized(<functionId>)
{
}
else
{
}
```

There is no nedd to pass the user logged, the function already know it.

Test if user has a role
-------

To test if the logged user has a specified role is sufficient to call the hasRole in this way:

```php
if ($this->get('userAuthorizedFunctions')->hasRole(<roleId>)
{
}
else
{
}
```

There is no nedd to pass the user logged, the function already know it.
