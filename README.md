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
git clone [https://github.com/tu-usuario/tu-proyecto.git](https://github.com/tu-usuario/tu-proyecto.git)
cd tu-proyecto
```

### 2. Instalar dependencias de PHP (Composer)

Si no tienes PHP local, usa este contenedor para instalar Composer:
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
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

### Uso
App: http://127.0.0.1
