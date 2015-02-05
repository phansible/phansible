# Phansible
[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/phansible/phansible?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/phansible/phansible.svg?branch=master)](https://travis-ci.org/phansible/phansible)
[![Coverage Status](https://coveralls.io/repos/Phansible/phansible/badge.png)](https://coveralls.io/r/Phansible/phansible)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phansible/phansible/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Phansible/phansible/?branch=master)

[Phansible](http://phansible.com) is a simple generator for Vagrant projects, targeting PHP development environments, using Ansible as Provisioner.

It was inspired by [PuPHPet](http://puphpet.com).

The project is built on top of [Silex](http://silex.sensiolabs.org/), using [Flint](http://flint.readthedocs.org/).

## Contributions

Contributions are always welcome, please have a look at our issues to see if there's something you could help with.
You can also join us on [gitter](https://gitter.im/phansible/phansible).

## TO DO

- Deprecate 1.0 branch and put master into production
- CI our generated roles (@naxhh is working on this)
- API for generating roles outside the Web (@erikaheidi is working on this)
- New technologies (request for your favourite ones!)
- More documentation on how to customize things 
- Take a look at our [issues](https://github.com/phansible/phansible/issues).

## Setup

- Clone the repo: ```git clone https://github.com/Phansible/phansible.git```
- Go into the phansible folder ```cd phansible/```
- Install the dependencies with [composer](https://getcomposer.org/): ```php composer install```
- Run the php built in server: ```php -S 0.0.0.0:8080 -t web/``` 
- You can now go on [http://localhost:8080](http://localhost:8080) to see your modification.

As an alternative, you can also use the included Vagrant setup (requires Ansible).

## Tests
To run the tests just do:
```
 ./vendor/bin/phpunit
```

## Code style
To check the code style just do:
```
 ./vendor/bin/phpcs --standard=psr2 ./src
 ./vendor/bin/phpmd src/ text codesize,controversial,design,naming,unusedcode
```

When no errors appear you are ready to push your commits!
