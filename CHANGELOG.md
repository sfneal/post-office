# Changelog

All notable changes to `post-office` will be documented in this file

**NOTICE**: remember to change the composer.json 'version' before publishing new releases

## 0.1.0 - 2020-08-19
- initial release


## 0.1.1 - 2020-08-19
- removed SendMailAction because using SendMailJob::dispatchNow() accomplished the same goal
- refactored Sfneal/PostOffice/MailCenter/SendMailJob to SendMail


## 0.2.0 - 2020-08-14
- add support for Laravel 8
 
 
## 0.3.0 - 2020-10-06
- add support for php7.0 & 7.1
 
 
## 0.3.1 - 2020-10-07
- fix phpunit version requirement
 
 
## 0.4.0 - 2020-10-08
- add support for php8


## 0.4.1 - 2020-12-11
- fix issues with php8 compatibility
- optimize Travis CI config


## 0.5.0 - 2021-02-01
- bump min sfneal/queueables package version to 1.0


## 0.5.1 - 2021-04-05
- fix sfneal/queueables version constraint (^1.0)


## 0.6.0 - 2021-04-05
- cut support for php 7.0
- bump min sfneal/queueables version to ^2.0


## 0.7.0 - 2021-05-04
- cut support for php 7.3 & below
- bump min sfneal/users dev requirement to v0.11.3
- make ServiceProvider that publishes config files & views
- make test suite for testing Mailables, Notifications & SendMail jobs


## 0.8.0 - 2021-05-04
- add 'queue' & 'driver' keys to post-office config
- add use of 'post-office.queue' & 'post-office.driver' queue values
