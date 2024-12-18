# **FelterSport - Aplicación Web para Tienda Deportiva**

## **Descripción del Proyecto**
**FelterSport** es una aplicación web creada para facilitar la compra de artículos deportivos en una tienda virtual. Permite a los usuarios navegar por catálogos de productos, agregarlos al carrito de compras y simular el proceso de pago de forma intuitiva. 

Este proyecto tiene como objetivo digitalizar la experiencia de compra y ofrecer una plataforma eficiente para la gestión de productos y pedidos.

---

## **Funcionalidades Principales**
- **Catálogo de Productos**: Visualización de artículos deportivos con imágenes, descripciones y precios.
- **Carrito de Compras**: Posibilidad de agregar, editar y eliminar productos del carrito.
- **Simulación de Pagos**: Proceso de simulación de pago al finalizar el pedido.
- **Autenticación de Usuarios**: Permite el registro e inicio de sesión.
- **Panel de Administrador**: Gestiona inventario, productos y pedidos.
- **Notificaciones de Estado**: Actualización del estado de pedidos.

---

## **Tecnologías Utilizadas**
- **Frontend**:
  - **HTML5**: Estructura del proyecto.
  - **CSS3** y **Bootstrap**: Estilos responsivos y atractivos.
  - **JavaScript**: Funcionalidades interactivas para el usuario.

- **Backend**:
  - **PHP**: Procesamiento de solicitudes y lógica del servidor.
  - **MySQL**: Base de datos para la gestión de usuarios, productos y pedidos.

- **Otros**:
  - **XAMPP**: Servidor local para desarrollo y pruebas.
  - **phpMyAdmin**: Administración de la base de datos MySQL.

---

## **Instalación y Configuración**
Sigue estos pasos para ejecutar el proyecto en tu entorno local:

1. **Clonar el Repositorio**:
   ```bash
   git clone https://github.com/JosueMa98/FelterSport.git
   ```

2. **Configurar el Entorno Local**:
   - Instala **XAMPP** o cualquier otro servidor local.
   - Asegúrate de iniciar Apache y MySQL.

3. **Importar la Base de Datos**:
   - Abre `phpMyAdmin` en tu servidor local.
   - Importa el archivo `database/feltersport.sql` para crear las tablas necesarias.

4. **Configurar la Conexión a la Base de Datos**:
   - Abre el archivo `conexion.php` y configura tus credenciales:
     ```php
     $host = 'localhost';
     $user = 'root';
     $password = ''; // Contraseña vacía por defecto
     $database = 'feltersport';
     ```

5. **Iniciar la Aplicación**:
   - Guarda los archivos en la carpeta `htdocs` (si usas XAMPP).
   - Accede a `http://localhost/FelterSport` desde tu navegador.

---

## **Estructura del Proyecto**
```bash
FelterSport/
|-- database/
|   |-- feltersport.sql     # Archivo de la base de datos
|-- img/                    # Imágenes de productos
|-- php/
|   |-- conexion.php        # Configuración de la base de datos
|-- index.php               # Página principal del proyecto
|-- carrito.php             # Gestión del carrito de compras
|-- procesar_pago.php       # Simulación de pago
|-- login.php               # Inicio de sesión
|-- registro.php            # Registro de usuarios
|-- dashboard_admin/                  # Panel de administración
```

---

## **Créditos**
- **Desarrollador**: Victor Josué Maldonado Arana
- **Institución**: Instituto Tecnológico de Culiacán
- **Contacto**: [Correo electrónico](L20171583@culiacan.tecnm.mx)

---

## **Licencia**
Este proyecto está licenciado bajo la [Licencia Apache 2.0](LICENSE).

---

## **Imágenes **
![image](https://github.com/user-attachments/assets/34a7320c-59df-4b55-9034-4b2fc32e6a76)
![image](https://github.com/user-attachments/assets/cb06f6fc-acdc-4f23-8582-6e0c2299a600)
![image](https://github.com/user-attachments/assets/747fa8e9-dd18-4039-b680-28e0d8296640)
![image](https://github.com/user-attachments/assets/2e57d77f-a94f-4891-a559-e0cfa8f5bb51)





---

¡Gracias por visitar el proyecto FelterSport! 🏆🚴‍♂️

