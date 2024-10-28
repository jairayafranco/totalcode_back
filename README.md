# API de Órdenes de Pedidos

Esta API desarrollada en PHP  permite consultar información sobre órdenes de pedidos almacenadas en una base de datos. La API se ejecuta en un entorno local utilizando XAMPP y sigue el estándar REST para su estructura y funcionamiento.

## Características

- **Obtención de Órdenes**: Consulta las órdenes de pedidos almacenadas en la base de datos, incluyendo detalles como el cliente, número de orden y monto total.
- **Autenticación**: Implementación de un falso inicio de sesión para restringir el acceso a los datos de la API.
- **Estructura REST**: La API sigue una arquitectura REST, facilitando el acceso y manipulación de los datos.

## Tecnologías utilizadas

- **PHP**: Lenguaje principal para el desarrollo de la API.
- **MySQL**: Base de datos donde se almacenan los datos de las órdenes.
- **XAMPP**: Entorno de desarrollo local que integra Apache y MySQL para la ejecución de la API.

## Requisitos

- XAMPP (para Apache y MySQL)
- PHP 7.4 o superior

## Instalación

1. Clona este repositorio en el directorio raíz de tu servidor Apache (por ejemplo, `htdocs` en XAMPP).
   
   ```bash
   https://github.com/jairayafranco/totalcode_back.git
   ```

2. Importa la base de datos MySQL utilizando el archivo SQL proporcionado.

3. Configura las credenciales de la base de datos en el archivo `config.php` (se dejan valores por defecto).

4. Inicia el servidor Apache y MySQL desde XAMPP.

5. Accede a la API en http://localhost/totalcode_back/public/api (esta ruta no muestra informacion, revisar Endpoints).

## Endpoints de la API

- **GET /orders**: Obtiene la lista de todas las órdenes.
- **GET /orders?month=1&status=3**: Obtiene las ordenes segun el filtro.
- **POST /login**: Falso inicio de sesión para obtener acceso a los datos.
- **POST /check**: Para validar el token.

## Credenciales Login

```bash
username: admin
password: 1234
```

## Ejemplo de Uso

### Ejemplo de llamada a la API desde JavaScript

```javascript
$.ajax({
    url: "http://localhost/nombre-del-repositorio/orders",
    type: "GET",
    success: function(data) {
        console.log(data); // Muestra las órdenes en la consola
    },
    error: function(error) {
        console.error("Error al obtener órdenes:", error);
    }
});
```

## Estructura del Proyecto

```cpp
    📁app
        └── 📁controllers
            └── AuthController.php
            └── OrderController.php
        └── 📁core
            └── Router.php
        └── 📁models
            └── Auth.php
            └── Order.php
        └── 📁routes
            └── api.php
    └── 📁config
        └── config.php
        └── database.php
    └── 📁public
        └── .htaccess
        └── index.php
```
