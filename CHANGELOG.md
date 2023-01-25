# Changelog

<!-- Prefixes: "fix: ..." ; "new: ..." ; "update: ..." -->

## 1.2.0 - 2023-01-25

- update: generate config for PHP 8.2

## 1.1.5 - 2022-03-14

- fix: update the github workflows files to run style-fix into the tests workflow 

## 1.1.4 - 2022-03-07

- fix: update the Makefile stubs to add the command `make help`

## 1.1.3 - 2022-03-07

- fix: use cache for composer dependencies in style-fix.yml workflow stub

## 1.1.2 - 2022-02-27

- fix: publish the `php-cs-fixer` package configuration file with the correct name

## 1.1.1 - 2022-02-26

- fix an error on lumen, where `config_path()` does not exist

## 1.1.0 - 2022-02-26

- added the detection of already ran tasks
- added the possibility to force ignore / re-run already ran tasks

## 1.0.0 - 2022-02-25

- initial release
