## Laravel Nova MySQL Server Managment

Laravel Nova MySQL Server Management to do:
- Create new database
- Delete database
- Repair database
- Add new user
- Delete user
- Change user password
- Add user to database
- Revokes user from database

## Installation

You can install the package in to a Laravel app that uses Nova via composer:

```bash
composer require naif/nova-mysql
```

## Usage:
Add the below to app/Providers/NovaServiceProvder.php

```php
public function tools()
  {
      return [
           new NovaMysql()
      ];
  } 
```

Add the below to your .env file

```php
CPANEL_HOST=YOUR_CPANEL_HOST_IP
CPANEL_DOMAIN=YOUR_DOMAIN_WITHOUT_HTTPS
CPANEL_PORT=MYSQL_PORT default 2083
CPANEL_USERNAME=YOUR_WEB_HOSTING_USERNAME
CPANEL_PASSWORD=YOUR_WEB_HOSTING_PASSWORD
CPANEL_PREFIX=YOUR_CPANEL_PREFIX prefix_DatabaseName
```

## Screenshots
<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/first.png" width="700">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/second.png" width="700">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/third.png" width="700">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/fourth.png" width="700">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/fifth.png" width="700">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-mysql/master/screenshots/six.png" width="700">




## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License:
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
