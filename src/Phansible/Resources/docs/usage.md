# Usage Instructions

If you never used Vagrant, it's a good idea to check some [tutorial](http://www.erikaheidi.com/vagrant/) before using this generator, so you can make further customizations according to your project needs.
Think about Phansible as a bootstrap generator, with a basic structure for a PHP web server.

## Requirements

You need to have them installed:

- Vagrant
- VirtualBox
- Ansible

Phansible uses nfs synced folders by default, for better performance - if your Host OS is Linux, you'll need to install **nfsd**.

### 1. Download and unpack
Choose the options you want and download the Bundle. Unzip to a folder.

### 2. vagrant up
Go to the directory and run `vagrant up` to test the provision.
