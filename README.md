**Nombre del proyecto**: **Conexión Laboral**
Plataforma web para conectar personas desempleadas o con dificultades de acceso al mercado laboral con empleadores que requieren servicios presenciales de baja y media cualificación.

---

## Tabla de contenidos

1. [Descripción](#descripción)
2. [Características](#características)
3. [Tecnologías](#tecnologías)
4. [Requisitos](#requisitos)
5. [Instalación](#instalación)
6. [Configuración](#configuración)
7. [Estructura del proyecto](#estructura-del-proyecto)
8. [Uso](#uso)
9. [Migraciones y seeders](#migraciones-y-seeders)
10. [Pruebas](#pruebas)
11. [Despliegue](#despliegue)
12. [Roadmap](#roadmap)
13. [Contribuciones](#contribuciones)
14. [Licencia](#licencia)

---

## Descripción

````
Conexión Laboral``` es una aplicación web desarrollada con Laravel y MySQL que facilita la publicación y búsqueda de ofertas de trabajo de baja y media cualificación. Permite a empleados registrarse, completar su perfil, postularse a trabajos y comunicarse con empleadores mediante un chat interno. Los empleadores pueden publicar ofertas, filtrar candidatos, gestionar postulaciones y evaluar empleados.

Este proyecto fue desarrollado en el marco de la Hackathon del SENA con un MVP planificado a un mes.

---

## Características
- Registro y autenticación de empleados y empleadores
- Creación y publicación de ofertas de trabajo
- Sistema de postulación y gestión de candidaturas
- Paneles de usuario diferenciados (empleado, empleador, administrador)
- Chat interno persistente (solo texto)
- Calificaciones y evaluaciones mutuas
- Filtros de búsqueda: ciudad, tipo de trabajo, salario, reputación
- Planes de membresía (Gratuito, Estándar, Premium)
- Notificaciones por correo y plataforma (PWA)
- Gestión de cuentas y seguridad (bcrypt, SSL, roles)
- Función de eliminación de datos según Ley 1581 de Colombia

---

## Tecnologías
- **Framework**: Laravel 10
- **Front-end**: Bootstrap 5, JavaScript
- **Base de datos**: MySQL (XAMPP en desarrollo)
- **Control de versiones**: Git & GitHub
- **Entorno**: PHP 8.x, Composer
- **Deployment**: Hosting compartido / VPS / DigitalOcean

---

## Requisitos
- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (para assets)
- Git

---

## Instalación
1. Clonar repositorio:
   ```bash
   git clone https://github.com/tu-usuario/conexion-laboral.git
   cd conexion-laboral
````

2. Instalar dependencias de PHP:

   ```bash
   composer install
   ```
3. Instalar dependencias de Node:

   ```bash
   npm install
   npm run dev
   ```
4. Copiar archivo de entorno:

   ```bash
   cp .env.example .env
   ```
5. Generar clave de aplicación:

   ```bash
   php artisan key:generate
   ```

---

## Configuración

1. Configura los datos de la base de datos en `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=conexion_laboral
   DB_USERNAME=root
   DB_PASSWORD=
   ```
2. Configura credenciales de correo para notificaciones en `.env`:

   ```dotenv
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tu_usuario
   MAIL_PASSWORD=tu_contraseña
   MAIL_ENCRYPTION=tls
   ```

---

## Estructura del proyecto

```
/app
  /Http
    /Controllers
    /Middleware
  /Models
/database
  /migrations
  /seeders
/resources
  /views
  /js
  /sass
/routes
  web.php
  api.php
```

---

## Uso

1. Ejecuta migraciones y seeders:

   ```bash
   php artisan migrate --seed
   ```
2. Levanta el servidor local:

   ```bash
   php artisan serve
   ```
3. Accede en tu navegador a `http://127.0.0.1:8000`

---

## Migraciones y seeders

* Las migraciones se encuentran en `database/migrations`.
* Los seeders en `database/seeders` para datos de prueba (roles, planes, usuarios demo).

---

## Pruebas

* Ejecutar pruebas unitarias:

  ```bash
  php artisan test
  ```
* Pruebas de carga básicas con Apache Benchmark o similares.

---

## Despliegue

1. Subir al servidor o VPS.
2. Configurar entorno (`.env`) y dependencias.
3. Ejecutar migraciones en producción:

   ```bash
   php artisan migrate --force
   ```
4. Configurar SSL y cron jobs (notificaciones, expiración).

---

## Roadmap

* Integración de motor de búsqueda full-text
* Notificaciones push PWA
* Geolocalización de ofertas
* App móvil (iOS/Android)
* Automatización CI/CD con GitHub Actions

---

## Contribuciones

Contribuciones, issues y solicitudes de mejoras son bienvenidas.

1. Fork del proyecto
2. Crear branch para la función (`git checkout -b feature/nombre-funcion`)
3. Commit de tus cambios (`git commit -m 'Agrega nueva función'`)
4. Push al branch (`git push origin feature/nombre-funcion`)
5. Abre un Pull Request

---

## Licencia

Este proyecto está bajo la [Licencia MIT](LICENSE).
