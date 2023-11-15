# proyecto_1_M07
proyecto_1_M07: Axel y Marc

Passos necessaris abans de desplegar una aplicació Laravel:

Disposem de la següent comanda per generar els assets estàtics de Vite (al directori public/build):

npm run build

Directori vendor amb les dependències PHP del projecte instal·lades
composer install

Directori node_modules amb les dependències JS del projecte instal·lades
npm install

Fitxer .env creat i configurat (amb APP_KEY generada)
cp .env.example .env
nano .env
php artisan key:generate 

Permisos per visualitzar fitxers del disc atorgats
php artisan storage:link

Migracions (migrations) i germinadors (seeders) executats
php artisan migrate
php artisan db:seed



.
