# Vagrant Crash-course

[Vagrant](http://vagrantup.com) is a tool that enables creation of development environments that are portable, reproducible and disposable. With a simple
`vagrant up`, a virtual machine is booted and configured to run your application.

Phansible helps you bootstrap a Vagrant project using [Ansible](http://www.ansible.com) as provisioner.
This page gives you a hand if you are new to Vagrant.

### Installation
Head to the [Vagrant downloads page](http://www.vagrantup.com/downloads.html) and get the appropriate package for your OS.
You'll need to have [VirtualBox](https://www.virtualbox.org/) installed as well - download the newest version from [here](https://www.virtualbox.org/wiki/Downloads).

## Vagrant Commands
This is a quick reference on the basic Vagrant commands:

<table class="ui table segment">
    <thead>
        <tr>
            <th>Command</th>
            <th>Description</th>
            <th>Common Usage</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>up</td>
            <td>Boots up the machine and fires provision</td>
            <td>When the VM is not running yet</td>
        </tr>
        <tr>
            <td>reload</td>
            <td>Reboots the machine</td>
            <td>When you make changes to the Vagrantfile</td>
        </tr>
        <tr>
            <td>provision</td>
            <td>Runs only the provisioner(s)</td>
            <td>When you make changes in the Provisioner scripts</td>
        </tr>
        <tr>
            <td>init</td>
            <td>Initializes a new Vagrantfile based on specified box url</td>
            <td>When you want to generate a Vagrantfile</td>
        </tr>
        <tr>
            <td>halt</td>
            <td>Turns off the machine</td>
            <td>When you want to turn off the VM</td>
        </tr>
        <tr>
            <td>destroy</td>
            <td>Destroys the virtual machine</td>
            <td>When you want to start from scratch</td>
        </tr>
        <tr>
            <td>suspend</td>
            <td>Suspends execution</td>
            <td>When you want to save the machine state</td>
        </tr>
        <tr>
            <td>resume</td>
            <td>Resumes Execution</td>
            <td>When you want to recover a previously suspended vm</td>
        </tr>
        <tr>
            <td>destroy</td>
            <td>Destroys the virtual machine</td>
            <td>When you want to start from scratch</td>
        </tr>
      <tr>
          <td>ssh</td>
          <td>Logs in via ssh (no password is required)</td>
          <td>When you want to make manual changes or debug</td>
      </tr>
      <tr>
          <td>global-status</td>
          <td>Shows global information about VMs</td>
          <td>When you want to check which VMs are running and control them individually</td>
      </tr>
    </tbody>
</table>

## Vagrant Terminology

### Boxes
A box is basically a bundle containing an installed operating system (and some basic stuff), for a specific _provider_ (e.g. VirtualBox). Vagrant will replicate this basic image for your virtual machine. When you setup your project, you define which base box you want to use. The box will be downloaded and imported to the system when you use it for the first time.

### Host and Guest
The Host machine / OS is the one who starts Vagrant. The Guest machine, as you can guess, is the virtual machine started by the Host.

### Providers
A provider will handle the virtualization process. VirtualBox is the default Vagrant provider, but you could also use VMWare, KVM and others. Installation of extra plugins might be required for other providers to work. VMWare, for instance, also requires registering a license key.

### Plugins
A plugin can add extra functionality to Vagrant, like supporting a new Provider.

### Provisioners
A provisioner will automate the setup of your server, installing packages and performing tasks in general. Using a provisioner is not mandatory, but not using it would make Vagrant worthless, since you would have to login and setup your environment manually, just as you were used to do before (and you could just use VirtualBox alone).
Phansible uses [Ansible](http://www.ansible.com) as provisioner.

### Vagrantfile
The Vagrantfile will hold your machine definitions, and it's usually placed on your application root folder. This file is written in Ruby, but it's basically a set of variable definitions, very straightforward. We'll have a chapter dedicated to the Vagrantfile and its common configuration options.

### Shared / Synced Folder
It's useful to have a common space shared between the Host and the Guest machines. With a shared folder, you can still edit your files with your favorite IDE installed on the Host machine, using the Guest machine only as a test server.


<div class="ui raised right aligned segment">
<em>This quick Vagrant manual is kindly brought to you by <strong><a href="https://leanpub.com/vagrantcookbook">Vagrant Cookbook</a></strong> <i class="food icon"></i></em>
</div>