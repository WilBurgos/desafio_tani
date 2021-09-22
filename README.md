# Tani
```bash
Repositorio creado con motivo de evaluación técnica
```
# git clone / Windows
```bash
git clone https://github.com/WilBurgos/desafio_tani.git --config core.autocrlf=input
```
# git clone / Linux
```bash
git clone https://github.com/WilBurgos/desafio_tani.git
```
# Env
```bash
Crear el archivo .env dentro de la carpeta del proyecto, copiar las variables que están en ".env.example"
Si tienes el proyecto en "Windows", agregar las siguientes variables el ".env" del proyecto
WWWGROUP=1000
WWWUSER=1000
```
# Docker compose
```bash
Ejecutar el comando "docker-compose up -d --build" dentro de la carpeta del proyecto
```
# Composer install
```bash
Dentro del proyecto, ejecutar el comando "composer install"
```
# Composer install / Docker Desktop
```bash
Si no cuentas con composer instalado en windows, o no te reconoce el comando composer/php.
Ve a tu aplicación docker desktop, en la sección de contenedores despliega el contenedor que está corriendo la aplicación.
Encuentra la opción "desafio_tani_laravel.test_1" que tiene ocupado el "puerto 80", de lado derecho encontrarás unas opciones
Hacer clic en "CLI"
Ejecutar el comando "composer install"
```
# Artisan Key
```bash
Ejecutar el comando "php artisan key:generate" dentro de la carpeta del proyecto
```
# Migración y Seeder
```bash
Ejecutar comando "php artisan migrate:fresh --seed"
```
# Run aplication
```bash
Ir a tu navegador predeterminado e ir a la dirección "http://localhost/"
* Si no muestra la bienvenida de Laravel, hacer lo siguiente:
- Limpiar storage de la ruta
- Parar el puerto 80 del contenedor que tiene la aplicación en docker (desafio_tani_laravel.test_1)
- Iniciar de nuevo el puerto 80 (desafio_tani_laravel.test_1)
- Recargar la página vaciando la caché
```
# Postman
```bash
Probar las rutas en postman
```
- [Probar rutas](https://www.getpostman.com/collections/442985d5f8f094300dd8)
