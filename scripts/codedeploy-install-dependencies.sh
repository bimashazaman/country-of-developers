cd /var/www/pokersocial
cp /home/ubuntu/acehigh/codedeploy-env/.env /var/www/pokersocial/.env
COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader --no-dev
npm install
npm run build
