# Clínica MediCitas - Sistema de Gestión de Citas Médicas

Esto corresponde al taller #12 de la clase de backend

---

## Requisitos Previos

- PHP >= 8.2
- Composer
- SQLite o MySQL

---

## Instalación y Configuración

1. Clonar el repositorio:
   git clone https://github.com/sappho7124/Taller-Laravel-Pruebas-y-Depuracion
   cd Taller-Laravel-Pruebas-y-Depuracion

2. Instalar dependencias:
   composer install

3. Configurar el entorno:
   cp .env.example .env
   php artisan key:generate

---

## Ejecución de Migraciones y Seeders

Para crear las tablas en la base de datos y cargar los registros de prueba:

php artisan migrate --seed

Para reiniciar completamente:
php artisan migrate:fresh --seed

---

## Ejecución de la Suite de Pruebas Automatizadas

Las pruebas están configuradas para ejecutarse sobre una base de datos en memoria.

Para ejecutar todas las pruebas automatizadas:
php artisan test

Para ejecutar específicamente la clase de pruebas del taller:
php artisan test --filter=CitaTest

### Casos de prueba evaluados:
1. test_muestra_citas_confirmadas: Filtro de citas por estado "confirmada".
2. test_agendar_cita_y_envio_correo: Registro de cita autenticada, persistencia en BD y notificación por correo al médico.
3. test_detecta_problema_n_mas_1: Diagnóstico del problema N+1 y verificación de carga ansiosa (eager loading).

---

## Ejecutar el Servidor Local

php artisan serve

Accede a la interfaz web en: http://localhost:8000/citas
EOF