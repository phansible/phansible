# Phansible

[![Build Status](https://travis-ci.org/Phansible/phansible.svg?branch=master)](https://travis-ci.org/Phansible/phansible)
[![Coverage Status](https://coveralls.io/repos/Phansible/phansible/badge.png)](https://coveralls.io/r/Phansible/phansible)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Phansible/phansible/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Phansible/phansible/?branch=master)

[Phansible](http://phansible.com) is a simple generator for Vagrant projects, targeting PHP development environments, using Ansible as Provisioner.

It was inspired by [PuPHPet](http://puphpet.com).

The project is built on top of [Silex](http://silex.sensiolabs.org/), using [Flint](http://flint.readthedocs.org/).

## Contributions

Contributions are welcome, specially for adding new Ansible Roles for new tasks / packages / services.
The Ansible Roles are located in a separated repository: https://github.com/Phansible/phansible-roles

## TO DO

- Databases
- More customization options
- More packages to choose from and option to add custom packages

## Setup

- Clone the repo: ```git clone https://github.com/Phansible/phansible.git```
- Go into the phansible folder ```cd phansible/```
- Install the dependencies with [composer](https://getcomposer.org/): ```php composer install```
- Run the php build in server: ```php -S 0.0.0.0:8080 -t web/```
- You can now go on [http://localhost:8080](http://localhost:8080) to see your modification.