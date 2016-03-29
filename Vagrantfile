# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.provision :shell, :path => "vagrant-bootstrap/setup.sh"

  config.vm.network :forwarded_port, guest: 80, host: 8181
  config.vm.provider "virtualbox" do |v|
    v.name = "Haggis"
  end

  config.vm.define "dev", primary: true do |dev|
    dev.vm.box = "vagrant_ubuntu_12.04.3_amd64_virtualbox"

    dev.vm.box_url = "http://nitron-vagrant.s3-website-us-east-1.amazonaws.com/vagrant_ubuntu_12.04.3_amd64_virtualbox.box"

    config.vm.synced_folder ".", "/vagrant", :mount_options => ["dmode=777", "fmode=666"]
  end

  # config.vm.provider :aws do |aws, override|
  #   aws.access_key_id = ENV['AWS_KEY']
  #   aws.secret_access_key = ENV['AWS_SECRET']
  #   aws.keypair_name = ENV['AWS_KEYNAME']

  #   aws.ami = "ami-a73264ce"
  #   aws.availability_zone = "us-east-1a"
  #   aws.instance_type = "t1.micro"

  #   aws.security_groups = ["DoubleBlue Development Team"]
  #   elastic_ip = "23.93.231.20"
  #   override.vm.box = "dummy"
  #   override.vm.box_url = "https://github.com/mitchellh/vagrant-aws/raw/master/dummy.box"
  #   override.ssh.username = "ubuntu"
  #   override.ssh.private_key_path = ENV['AWS_KEYPATH']
  # end
end