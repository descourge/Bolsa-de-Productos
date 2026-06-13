# Bolsa de Productos - Sistema de Procesamiento de PDFs con Marca de Agua

Aplicación Full Stack desarrollada como prueba técnica para el procesamiento de documentos PDF mediante una arquitectura de microservicios.

El sistema permite a usuarios autenticados subir documentos PDF e imágenes para generar automáticamente una versión del PDF con una marca de agua transparente.

---

## Características

* Autenticación de usuarios mediante Laravel Breeze.
* Subida de documentos PDF.
* Subida de imágenes PNG/JPG como marca de agua.
* Procesamiento de PDFs mediante FastAPI.
* Generación de marcas de agua transparentes.
* Descarga de documentos procesados.
* Control de acceso por usuario.
* Entorno completamente dockerizado.

---

## Tecnologías Utilizadas

### Backend

* Laravel 13
* PHP 8.4
* PostgreSQL 17
* Laravel Breeze

### Servicio de Procesamiento

* FastAPI
* Python 3.13
* PyPDF
* Pillow
* ReportLab

### Infraestructura

* Docker
* Docker Compose
* Nginx

---

## Arquitectura

```text
Usuario
   ↓
Laravel
   ↓ HTTP
FastAPI
   ↓
Procesamiento PDF
   ↓
PostgreSQL
```

---

## Repositorio

Repositorio GitHub:

https://github.com/descourge/Bolsa-de-Productos

Clonar el repositorio:

```bash
git clone https://github.com/descourge/Bolsa-de-Productos.git

cd "Bolsa-de-Productos"
```

---

## Estructura del Proyecto

```text
Bolsa-de-Productos/
│
├── docker/
│   └── nginx/
│       └── default.conf
│
├── laravel-app/
│   ├── app/
│   ├── routes/
│   ├── resources/
│   ├── public/
│   ├── Dockerfile
│   └── .env.example
│
├── python-service/
│   ├── Dockerfile
│   ├── main.py
│   └── requirements.txt
│
├── docker-compose.yml
└── README.md
```

---

## Instalación

### 1. Copiar variables de entorno

Ingresar a la carpeta Laravel:

```bash
cd laravel-app
```

Copiar el archivo de configuración:

Linux/Mac:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

---

### 2. Levantar contenedores Docker

Desde la raíz del proyecto ejecutar:

```bash
docker compose up --build
```

---

### 3. Generar la clave de la aplicación

```bash
docker compose exec app php artisan key:generate
```

---

### 4. Ejecutar migraciones y seeders

```bash
docker compose exec app php artisan migrate --seed
```

---

### 5. Crear enlace simbólico de Storage

```bash
docker compose exec app php artisan storage:link
```

---

## Primer Uso

Después de levantar los contenedores por primera vez, es necesario ejecutar los siguientes comandos:

```bash
docker compose exec app php artisan key:generate

docker compose exec app php artisan migrate --seed

docker compose exec app php artisan storage:link
```

Una vez completados estos pasos, la aplicación estará lista para ser utilizada.

> **Nota:** El proyecto incluye los assets compilados de Vite (`public/build`) para simplificar la instalación y evitar dependencias adicionales durante la evaluación técnica.

---

## URLs del Sistema

### Aplicación Laravel

```text
http://localhost
```

### Servicio FastAPI

```text
http://localhost:8001
```

### Documentación Swagger

```text
http://localhost:8001/docs
```

---

## Credenciales de Prueba

Después de ejecutar:

```bash
docker compose exec app php artisan migrate --seed
```

se crearán automáticamente los siguientes usuarios:

| Nombre | Email                                         | Contraseña |
| ------ | --------------------------------------------- | ---------- |
| Luis   | [luis@example.com](mailto:luis@example.com)   | password   |
| Diego  | [diego@example.com](mailto:diego@example.com) | password   |
| Pablo  | [pablo@example.com](mailto:pablo@example.com) | password   |

Estas cuentas permiten probar autenticación, creación de documentos y validación de permisos entre usuarios.

---

## Funcionalidades Implementadas

* Registro e inicio de sesión de usuarios.
* Subida de documentos PDF.
* Subida de imágenes para marca de agua.
* Procesamiento de PDFs mediante microservicios.
* Descarga de documentos procesados.
* Persistencia en PostgreSQL.
* Restricción de acceso a documentos por propietario.
* Entorno completamente dockerizado.

---

## Seguridad

El sistema implementa las siguientes medidas de seguridad:

* Acceso autenticado.
* Validación de archivos PDF e imágenes.
* Control de acceso por usuario.
* Protección contra acceso no autorizado a documentos.
* Políticas de autorización mediante Laravel.

---

## Servicios Docker

| Servicio   | Puerto |
| ---------- | ------ |
| Nginx      | 80     |
| FastAPI    | 8001   |
| PostgreSQL | 5432   |

---

## Flujo Principal

1. El usuario inicia sesión.
2. Crea un nuevo documento.
3. Sube un PDF.
4. Sube una imagen para marca de agua.
5. Laravel envía los archivos a FastAPI.
6. FastAPI procesa el PDF.
7. Laravel almacena la información en PostgreSQL.
8. El usuario descarga el documento procesado.

---

## Mejoras Futuras

* Selección dinámica de posición de la marca de agua.
* Rotación configurable de la marca de agua.
* Procesamiento asíncrono mediante colas.
* Vista previa del PDF.
* Integración con almacenamiento en la nube (AWS S3).
* Pruebas unitarias e integración.

---

## Autor

Luis Faúndez

GitHub:
https://github.com/descourge
