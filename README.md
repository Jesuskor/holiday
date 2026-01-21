# Proyecto Laravel con Docker Sail

Este proyecto es una aplicación desarrollada con Laravel que utiliza [Laravel Sail](https://laravel.com/docs/10.x/sail) para la gestión del entorno de desarrollo con Docker de manera simplificada.

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalados:
* **Docker Desktop** (Activo y ejecutándose)
* **Git**

---

## Instalación y Configuración

Sigue estos pasos detallados para levantar el proyecto en tu entorno local:

### 1. Clonar el repositorio
```bash
git clone https://github.com/Jesuskor/holiday
cd holiday
```

### 2. Instalar dependencias de PHP (Composer)

Si no tienes PHP local, usa este contenedor para instalar Composer:
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php84-composer:latest \
composer install --ignore-platform-reqs
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
```
Nota sobre el idioma: Si deseas que las validaciones y el sistema se muestren en español, asegúrate de modificar las siguientes variables en tu .env:
```bash
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES
```

### 4. Levantar el entorno
```bash
./vendor/bin/sail up -d
```

### 5. Configurar Base de Datos y Seeders
Asegúrate de que tu .env tenga estos valores:
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
Luego ejecuta:
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 6. Frontend y Ejecución
Instala las dependencias de Node y arranca el entorno de desarrollo:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail composer run dev
```

### Acceso al sistema
App: http://127.0.0.1

### Usuario de prueba
```bash
Email: admin@holiday.com
Password: 123
```
---

### Comandos útiles
Detener contenedores:
```bash
./vendor/bin/sail stop
```
