"# easy-picky"
# Install project
composer install
# Run database creation and fixtures
composer load-fixtures
# Add this line in your VirtualHost configuration for Apache users
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
