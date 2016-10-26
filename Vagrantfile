# -*- mode: ruby -*-
# vi: set ft=ruby :

require "yaml"

Vagrant.configure("2") do |config|
    config.vm.box = "michaelward82/trusty64-php7"
    config.vm.box_version = "= 1.1.13"
    config.vm.network "private_network", ip: "192.168.30.11"
    config.vm.hostname = "vagrant-api"

    config.vm.provision "shell", inline: <<-SHELL
        # Update and install packages
        sudo apt-get update
        sudo apt-get install -y mc
        sudo apt-get install -y php7.0-gd
        sudo apt-get install -y php-xml
        sudo apt-get install -y git

        # Direct Apache home directory to project
        sudo rm -rf /var/www/html
        sudo ln -s /vagrant/web /var/www/html

        # Set Apache user same as CLI user
        sed -e "s/www-data/vagrant/" /etc/apache2/envvars > ~/apache_envvars
        sudo mv ~/apache_envvars /etc/apache2/envvars

        # Allow .htaccess for Apache
        sudo bash -c 'printf "\n" >> /etc/apache2/sites-enabled/000-default.conf'
        sudo bash -c 'printf "<Directory /var/www/>\n" >> /etc/apache2/sites-enabled/000-default.conf'
        sudo bash -c 'printf "    AllowOverride All\n" >> /etc/apache2/sites-enabled/000-default.conf'
        sudo bash -c 'printf "</Directory>\n" >> /etc/apache2/sites-enabled/000-default.conf'

        # Configure PHP
        sudo touch /etc/php/7.0/apache2/conf.d/user.ini
        sudo bash -c 'printf "realpath_cache_size = 4096k\n" >> /etc/php/7.0/apache2/conf.d/user.ini'
        sudo bash -c 'printf "post_max_size = 64M\n" >> /etc/php/7.0/apache2/conf.d/user.ini'
        sudo bash -c 'printf "upload_max_filesize = 64M\n" >> /etc/php/7.0/apache2/conf.d/user.ini'

        # Restart services
        sudo service apache2 restart

        # Install composer
        curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
    SHELL
end
