# Contributing to Phansible

You want to contribute to Phansible? YAY! In this page you will find some important instructions and guidelines.
 The first thing to do is fork our main repository: [https://github.com/phansible/phansible](https://github.com/phansible/phansible) .

## Quick Guidelines

We appreciate any contributions; however, we recommend that before starting something "big", create an issue on GitHub, so the core
developers can discuss the idea with you.

Phansible is meant to be **simple**, as Ansible itself. It's meant to be used as a bootstrapping tool, so you can get started quickly,
and users are encouraged to learn how to customize and add their own roles.

### Contributing additional roles
If you have an idea for a role that is very specific (a framework-specific role for instance),
you can still create a Pull Request for our **[Additional Roles](https://github.com/Phansible/additional-roles)** repository. This repository was created to collect roles that can be
easily integrated with Phansible bundles, but don't need to be in the main UI form.

### Contributing to the main website
New additions to the UI, including new roles or new settings, normally involve more work, cause at the moment you'll need to edit the
BundleController and also make sure you keep compatibility with the different web servers and boxes currently available.
If you feel that it's going to be a lot of work or a lot of changes, please open an issue on Github first, so the core
developers can discuss it with you.

We appreciate the use of PSR-2 coding standards.

## Installing Phansible

First, clone your forked Phansible repo in your local machine. Then go to the project directory and
install the dependencies with composer.

In case you don't have composer installed yet:

    $ curl -sS https://getcomposer.org/installer | php

Now install the dependencies:

    $ php composer.phar install

### Running Phansible locally

The easiest way to get Phansible up and running is by using the built-in PHP server. This will require you to have PHP 5.4+ installed locally.

After cloning your forked Phansible repository in your local machine, go to the project directory and run:

    php -S 0.0.0.0:8000 -t web/

Now point your browser to `http://localhost:8000` and you will be able to access your local Phansible copy.

### Using the Vagrant setup included

Phansible also has a Vagrant setup for development. Go to the project root directory and run:

    $ vagrant up

Point your browser to `http://192.168.56.121` and you will be able to access your local Phansible copy.
