# Changelog

All notable changes to `post-office` will be documented in this file

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
