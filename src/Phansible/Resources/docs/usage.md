# Usage Instructions
Phansible helps you bootstrap a [Vagrant](http://vagrantup.com) project using [Ansible](http://www.ansible.com) as provisioner.

If you are new to Vagrant, have a look at our _[Vagrant Crash Course](/docs/vagrant)_ to get an overview and basic usage instructions.
If you are new to Ansible, have a look at their excellent documentation: [Ansible Docs](http://docs.ansible.com/).

## Requirements

In order to run a Phansible bundle, you'll need the following software:

- [Vagrant](http://www.vagrantup.com/downloads.html)
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
- [Ansible](http://docs.ansible.com/intro_installation.html)

**Windows Compatibility**: Ansible cannot be installed on Windows machines for now, but we got you covered: Phansible implements a workaround that runs the provisioning
inside the Guest machine, with a local SSH connection. This is enabled by default, but you can also disable Windows compatibility
in the "Advanced Options" of the VM settings, when creating your bundle.

**NFS on Linux**: Phansible bundles use NFS synced folders by default, for better performance - if your Host OS is Linux, you'll need to install **nfsd**.

## Creating your bundle

Choose the options you want for your Vagrant setup. The defaults will set up a Nginx+PHP5-fpm server, running PHP 5.6 in a Ubuntu 14.04 server.

## Running the downloaded bundle
Extract the contents of the zip file into a directory.
Go to the directory and run:

`$ vagrant up`

This will initialize the machine and run the Ansible provisioning.

## Customizing your bundle

Check our doc page _[Customizing your bundle](/docs/customize)_ for detailed instructions on how to add tasks and roles to your downloaded bundle.