def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

Vagrant.configure("2") do |config|

    config.vm.provider :virtualbox do |v|
        v.name = "phansible"
        v.customize ["modifyvm", :id, "--memory", 512]
    end

    config.vm.box = "trusty64"
    config.vm.box_url = "https://vagrantcloud.com/ubuntu/boxes/trusty64/versions/14.04/providers/virtualbox.box"

    config.vm.network :private_network, ip: "192.168.56.121"
    config.ssh.forward_agent = true

    if which('ansible-playbook')
        config.vm.provision "ansible" do |ansible|
            ansible.playbook = "ansible/provision.yml"
            ansible.inventory_path = "ansible/inventories/dev"
            ansible.limit = 'all'
            ansible.extra_vars = { ansible_connection: 'ssh', ansible_ssh_args: '-o ForwardAgent=yes' }
        end
    else
        config.vm.provision :shell, path: "ansible/windows.sh"
    end

    config.vm.synced_folder "./", "/vagrant", id: "vagrant-root", :nfs => true
end
