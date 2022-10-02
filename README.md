"# easy-picky"
# Install project
composer install
copy .env.exemple => .env
set database url => .env DATABASE_URL
# Create JWT Key
php bin/console lexik:jwt:generate-keypair
# Run database creation and fixtures
composer load-fixtures
# Add this line in your VirtualHost configuration for Apache users
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
