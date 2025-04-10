# 🧰 MyJob - Plataforma de Microempleos

**MyJob** es una plataforma web enfocada en reducir el desempleo local, conectando empleadores con personas en búsqueda de microempleos presenciales de baja cualificación.

---

## 📌 Funcionalidades Actuales

### 🔐 Autenticación
- Registro de usuarios con validación de campos (nombre, correo, contraseña).
- Verificación si el correo ya está registrado.
- Contraseñas encriptadas con `password_hash()`.
- Inicio de sesión con manejo de sesiones (`session_start()`).
- Validación de credenciales usando `password_verify()`.
- Gestión de roles por defecto (actualmente se asigna automáticamente el rol `empleado`).

### 🎨 Interfaz con Bootstrap y SweetAlert2
- Formularios modernos con Bootstrap 5.
- Alertas elegantes y personalizadas usando **SweetAlert2**.
- Comprobaciones visuales amigables de errores y éxitos en login y registro.

---

## 📃️ Estructura de Base de Datos

**Tabla `usuarios`**:
```sql
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(255) NOT NULL,
  correo_electronico VARCHAR(255) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  rol ENUM('empleado', 'empleador', 'admin') NOT NULL DEFAULT 'empleado'
);
```

---

## 🔧 Archivos Clave
- `registerController.php`: Controla el proceso de registro y asigna el rol por defecto.
- `loginController.php`: Verifica credenciales y establece la sesión.
- `login.php` y `register.php`: Interfaces frontend para autenticación.

---

## 🧪 Próximas Tareas
- Creación de paneles diferenciados por rol (`empleado`, `empleador`, `admin`).
- Implementar validaciones más avanzadas (regex, longitud, etc.).
- Mejoras en seguridad (CSRF tokens, validaciones backend más robustas).
- Agregar un sistema de verificación de cuenta por correo electrónico.

---

## 🤝 Colaboradores
- 👨‍💻 Tomás Esquivel Perdomo


