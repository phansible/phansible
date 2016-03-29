# Customizing your bundle
Phansible is meant to help you bootstrapping a Vagrant setup with Ansible. You are encouraged to explore the downloaded bundle
and extend your setup by adding new roles and tasks that are more specific for your project.

## Adding app-specific tasks

In many cases, in order to have our app up and running, we need to run more specific tasks, like clearing a cache or running composer. This specific tasks
can be placed in the special role "app", already included in your bundle.

This role has no default tasks, and it's supposed to hold tasks that are application-specific.

Let's say you want to run `composer install` to download the vendor libraries for your project. Edit the file
`ansible/roles/app/tasks/main.yml` and add the task:

    ---
    # application tasks to be customized and to run after the main provision

        - name: Run Composer
          become: false
          shell: /usr/local/bin/composer install chdir={{ project_root }}

To test the changes, run:

    $ vagrant provision

And the Ansible provisioning will run again. At the end you should see the execution of the "Run Composer" task.

You can add any other app-specific tasks in this role.

## Including a new Role

You can include custom roles in your bundle by just adding the role directory to the folder **"roles"** in your `ansible` directory,
and including it from the main `playbook.yml`.

Let's say you want to include a custom role to install a new service in your VM.

The role should follow this generic structure:

    ansible/roles/myCustomRole
    ├── handlers
    │   └── main.yml
    ├── tasks
    │   └── main.yml
    └── templates
        └── default.tpl

Where only the `tasks/main.yml` file is really mandatory. This file should contain the tasks necessary to install and configure the new service (say, a database for instance).

After including this folder inside the "roles" folder of your bundle (`ansible/roles`), you need to import it from the playbook. Just edit the file
**ansible/playbook.yml** and include the name of the role (folder name) in the **roles** array. Mind the order of inclusions, the tasks
are always executed in the order you define them, same applied for the roles included.

For this example, let's consider we would like to execute the role after the initial bootstrap of the server, but before the application-specific tasks
that are included in the "app" role:

    ---
    - hosts: all
      become: true
      vars:
        web_server: nginxphp
        servername: myApp.vb www.myApp.vb
        timezone: UTC
      vars_files:
        - vars/common.yml
        - [ "vars/nginxphp.yml", "vars/ws_defaults.yml" ]
      roles:
        - init
        - nginx
        - php5-fpm
        - myCustomRole #after initial bootstrap, before app-specific tasks
        - app
