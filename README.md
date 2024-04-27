
# Documentación del Proyecto: API GIF con Laravel 10, PHP 8.2, MySQL y Docker

Esta API consume los servicios de [giphy](https://giphy.com/) y ofrece cuatro servicios, con un endpoint público para autenticación y tres privados para operaciones relacionadas con gifs.

## Tecnologías Utilizadas
- **Lenguaje de Programación**: PHP 8.2
- **Framework**: Laravel 10
- **Base de Datos**: MySQL
- **Infraestructura de Contenedores**: Docker y Docker Compose

## Endpoints de la API
- **Autenticación Pública**: 
  - `POST http://localhost:8000/api/v1/auth/login`
  
- **Operaciones Privadas con Gifs**:
  1. **Consulta de Gifs por Query**:
     - `GET http://localhost:8000/api/v1/gif?query=cheeseburger&limit=10&offset=0`
  2. **Consulta de Gif por ID**:
     - `GET http://localhost:8000/api/v1/gif/GVaknm5baLdAc`
  3. **Guardar Gif como Favorito**:
     - `POST http://localhost:8000/api/v1/gif`

## Instalación y Configuración del Entorno Local

### Requisitos
Para ejecutar este proyecto localmente, necesitas tener instalados Docker y Docker Compose.

### Pasos para Levantar el Entorno
1. Clonar el repositorio del proyecto.

    ```bash
    git clone https://github.com/tomastp/giphy-api-challenge.git
    ```

2. Copiar el archivo `.env.example` a un nuevo archivo llamado `.env` y luego el archivo `.docker/mysql/.env.example` a un nuevo archivo llamado `.docker/mysql/.env` .

    ```bash
    cp .env.example .env
    cp .docker/mysql/.env.example .docker/mysql/.env
    ```

3. Construye los contenedores con Docker Compose con el siguiente comando:

   ```bash
   docker-compose build
   ```

4. Inicia los contenedores en modo desacoplado para mantenerlos en ejecución:

   ```bash
   docker-compose up -d
   ```

5. Dentro del contenedor de PHP, instalar dependencias:

   ```bash
   docker-compose exec app-server composer install
   ```

6. Dentro del contenedor de PHP, ejecuta las migraciones para crear las tablas en la base de datos:

   ```bash
   docker-compose exec app-server php artisan migrate
   ```

7. Aún dentro del contenedor de PHP, ejecuta este comando que creará las claves de cifrado necesarias para generar tokens de acceso seguro:

   ```bash
   docker-compose exec app-server php artisan passport:client --personal --no-interaction
   ```

Una vez completados estos pasos, la API estará disponible en `http://localhost:8000`.

### Creación de Usuario de Prueba
Para crear un usuario de prueba *(email: test@example.com, password: 1234)*, por ejemplo para propósitos de QA o pruebas, puedes ejecutar el siguiente comando desde el contenedor de PHP:

```bash
docker-compose exec app-server php artisan db:seed --class=UserSeeder
```

### Ejecución de Pruebas
Para ejecutar las pruebas y validar el correcto funcionamiento de la API **(recordar actualizar el archivo .env con la key de GIPHY_API_KEY correspondiente)**, utiliza el siguiente comando:

```bash
docker-compose exec app-server php artisan test
```

### UML
Dentro del directorio ./uml se encuentran los diagramas que representan la solución

### Postman
Dentro del directorio ./postman se encuentra la collección
