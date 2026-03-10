# Control Escolar

Sistema web de control escolar desarrollado con **Laravel** y **Tailwind CSS**. Permite gestionar usuarios (alumnos, maestros y administradores), materias y horarios a traves de una interfaz sencilla y moderna.

---

## Tecnologias utilizadas

- **PHP 8+** con **Laravel 11**
- **MySQL** como base de datos
- **Tailwind CSS** (via Vite) para los estilos
- **DBngin** para gestionar el servidor MySQL en local
- **TablePlus** para visualizar la base de datos

---

## Requisitos previos

- PHP >= 8.1
- Composer
- Node.js y npm
- MySQL corriendo (por ejemplo, con DBngin)

---

## Instalacion

\\ash
# 1. Instalar dependencias de PHP
composer install

# 2. Instalar dependencias de Node
npm install

# 3. Copiar el archivo de entorno
cp .env.example .env

# 4. Generar la clave de la aplicacion
php artisan key:generate
\
---

## Configuracion de la base de datos

Edita el archivo \.env\ con los datos de tu servidor MySQL:

\\env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=control_escolar
DB_USERNAME=root
DB_PASSWORD=
\
Luego crea las tablas ejecutando las migraciones:

\\ash
php artisan migrate
\
Si necesitas reiniciar la base de datos desde cero:

\\ash
php artisan migrate:fresh
\
---

## Levantar el proyecto

Abre dos terminales y ejecuta:

\\ash
# Terminal 1 - servidor PHP
php artisan serve

# Terminal 2 - compilador de assets (Tailwind)
npm run dev
\
El proyecto estara disponible en: http://localhost:8000

---

## Estructura de la base de datos

### Tabla users
| Campo               | Tipo    | Descripcion                      |
|---------------------|---------|----------------------------------|
| id                  | bigint  | Clave primaria                   |
| nombre              | string  | Nombre completo del usuario      |
| clave_institucional | string  | Clave unica del usuario          |
| email               | string  | Correo electronico               |
| password            | string  | Contrasena cifrada               |
| rol                 | enum    | admin, maestro o alumno          |
| activo              | boolean | Indica si el usuario esta activo |

### Tabla materias
| Campo  | Tipo   | Descripcion               |
|--------|--------|---------------------------|
| id     | bigint | Clave primaria            |
| nombre | string | Nombre de la materia      |
| clave  | string | Clave unica de la materia |

### Tabla horarios
| Campo       | Tipo   | Descripcion                |
|-------------|--------|----------------------------|
| id          | bigint | Clave primaria             |
| materia_id  | FK     | Referencia a materias      |
| usuario_id  | FK     | Referencia a users         |
| hora_inicio | time   | Hora de inicio de la clase |
| hora_fin    | time   | Hora de fin de la clase    |

---

## Rutas principales

| Metodo | URL                         | Descripcion                     |
|--------|-----------------------------|---------------------------------|
| GET    | /login                      | Vista de inicio de sesion       |
| POST   | /login                      | Procesar login                  |
| GET    | /register                   | Vista de registro               |
| POST   | /register                   | Crear nuevo usuario             |
| POST   | /logout                     | Cerrar sesion                   |
| GET    | /dashboard                  | Panel principal (requiere auth) |
| GET    | /admin/materia              | Listar materias y agregar nueva |
| POST   | /admin/materia              | Guardar nueva materia           |
| GET    | /admin/materiaeditar/{id}   | Formulario de edicion           |
| PUT    | /admin/materia/{id}         | Actualizar materia              |
| DELETE | /admin/materia/{id}         | Eliminar materia                |

---

## Funcionalidades actuales

- **Registro de usuarios** con nombre, clave institucional, correo, rol y contrasena
- **Inicio de sesion** con autenticacion de Laravel
- **Cierre de sesion**
- **Dashboard** con informacion del usuario autenticado y accesos rapidos
- **CRUD completo de materias**: crear, listar, editar y eliminar

---

## Estructura de carpetas relevante

\app/
+-- Http/Controllers/
|   +-- AuthController.php      # Login, registro, logout
|   +-- AdminController.php     # CRUD de materias
+-- Models/
    +-- User.php
    +-- Materia.php
    +-- Horario.php
database/
+-- migrations/                 # Definicion de tablas
resources/views/
+-- auth/
|   +-- login.blade.php
|   +-- register.blade.php
+-- dashboard.blade.php
+-- layouts/admin/
    +-- materia.blade.php
    +-- materiaeditar.blade.php
routes/
+-- web.php
\
---

## Autor

Proyecto desarrollado como practica de desarrollo web con Laravel.
