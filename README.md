<p align="left"><img src="https://raw.githubusercontent.com/cshawaus/up-dashboard/master/public/images/up-yeah-logo.jpg?token=AAHWB5VMLLODM5BSMCYBWJK7FFNFI" width="100"></p>

![license][license]
![php][php]
![laravel][laravel]
![production ready][production-ready]
[![last commit][last-commit]][last-commit-url]
[![contributors][contributors]][contributors-url]
[![sonarqube-quality][sonarqube-quality]][sonarqube-quality-url]
[![sonarqube-vulnerabilities][sonarqube-vulnerabilities]][sonarqube-vulnerabilities-url]
[![sonarqube-security][sonarqube-security]][sonarqube-security-url]

# up yeah dashboard
A simple project that provides a way to self-manage your own _up_ dashboard.

## Prerequisites
- PHP 7.4
- A web server with bcrypt support

## Installation
Run the following commands to get everything setup.

```bash
$ composer install --prefer-dist
$ yarn
$ yarn prod
```

### Development
The above commands will build production packages/code, if you prefer a development environment use the below instead.

```bash
$ composer install
$ yarn
$ yarn dev
```

## Configuration
Ensure you generate a key using the below command and fill in all the relevant configurations required for your environment in the `.env` file.

```bash
$ php artisan key:generate
```

### Migrations
To install the database tables run:

```bash
$ php artisan migrate
```

## Post-installation
Upon completing the configuration and navigating to the application in your browser, you will be asked to create an initial user account. I have opted to use authentication on the off chance someone happens to use this in a production environment even though it is not production ready.

You will also need to setup an API token

## Todo
- [ ] View transactions for accounts
- [ ] Dive into a transaction
- [ ] Customise accounts with different labels, emoji, etc.
- [ ] Configure webhooks
- [ ] See the status of webhooks
- [ ] Web notifications
- [ ] IFTTT integration
- [ ] User account management

## The legal bit
This dashboard is not endorsed nor offered by Up, it is a personal project and is not rated for security therefore you will be using this software at your own risk. Terms such as **up** and **up yeah** are trademarks of Up.

Copyright (c) 2020 Chris Shaw.

[license]: https://img.shields.io/github/license/cshawaus/up-dashboard
[php]: https://img.shields.io/badge/php-%5E7.4-blue
[laravel]: https://img.shields.io/badge/laravel-7-ff2d20
[production-ready]: https://img.shields.io/badge/prod%20ready-NO-critical

[sonarqube-quality]: https://sonarcloud.io/api/project_badges/measure?project=cshawaus_up-dashboard&metric=alert_status
[sonarqube-quality-url]: https://sonarcloud.io/dashboard?id=cshawaus_up-dashboard

[sonarqube-vulnerabilities]: https://sonarcloud.io/api/project_badges/measure?project=cshawaus_up-dashboard&metric=vulnerabilities
[sonarqube-vulnerabilities-url]: https://sonarcloud.io/dashboard?id=cshawaus_up-dashboard

[sonarqube-security]: https://sonarcloud.io/api/project_badges/measure?project=cshawaus_up-dashboard&metric=security_rating
[sonarqube-security-url]: https://sonarcloud.io/dashboard?id=cshawaus_up-dashboard

[last-commit]: https://img.shields.io/github/last-commit/cshawaus/up-dashboard
[last-commit-url]: https://github.com/cshawaus/up-dashboard/commits

[contributors]: https://img.shields.io/github/contributors/cshawaus/up-dashboard.svg
[contributors-url]: https://github.com/cshawaus/up-dashboard/graphs/contributors
