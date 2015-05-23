set :user,          "root"

ssh_options[:port] = "22"

set :use_sudo,      false
set :clear_controllers, false

set :domain,        "shop.devel.waszczuk.info"
set :deploy_to,     "/var/www/html/shop"

set :branch,            fetch(:branch, "develop") #cap -S branch=develop
set :symfony_env_prod,  fetch(:env, "dev") #cap -S env=prod

set :composer_options,  "--verbose --prefer-dist --optimize-autoloader --no-progress" #add --no-dev for prod - dla composera

role :web,           "91.228.196.87"                         # Your HTTP server, Apache/etc
role :app,           "91.228.196.87", :primary => true       # This may be the same as your `Web` server

set :webserver_user,      "apache"

task :upload_parameters do
    origin_file = "app/config/deploy/staging_parameters.yml"
    destination_file = shared_path + "/app/config/parameters.yml"

    try_sudo "mkdir -p #{File.dirname(destination_file)}"
    top.upload(origin_file, destination_file)
end
