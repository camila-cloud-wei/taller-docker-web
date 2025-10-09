# 🐳 Taller Docker - Grupo 14

## 👥 Equipo y Roles
- Líder técnico
- **Camila Martínez López** - Desarrollo Backend
- **Diana Paola Mopan Cabrera** - Desarrollo Frontend 
- **Jose David Arrieta Torres** - Base de Datos
- **Luis Alejandro Espinal Arango** - Configuración Docker
- Documentador
- Expositor

## 🎯 Objetivo del Ejercicio
Crear una aplicación web con PHP y MySQL usando contenedores Docker, implementando un formulario de contacto con validaciones y persistencia de datos.

## 📸 Capturas

### Formulario Completo
![Formulario](images/formulario.png)
*Formulario con 6 campos y validaciones visuales*

### phpMyAdmin
![phpMyAdmin](images/phpmyadmin.png)
*Administración de la base de datos en puerto 8081*

## 💻 Comandos Principales

```bash
#Apaga cualquier contenedor previo.
docker compose down -v

# Ejecución inicial
docker compose up -d --build

# Verificación de contenedores 
docker compose ps
#(phpMyAdmin no aparecía)

# Solución: Agregamos phpmyadmin al docker-compose.yml
# Luego reiniciamos todo
docker compose down -v
docker compose up -d --build

# Verificación final (todos los contenedores activos)
docker compose ps
```

## 💾 Almacenamiento de Datos
- ### Conexión PDO en db.php
    La clase PDO en creae una una instancia que representa la conexión con la base de datos, a la clase se le envían el parámetro de dsn con los datos necesarios para conectar a la base de datos como host, nombre de base de datos, usuario, contraseña e información del driver.
- ### Conexión PDO en db.php

## 🌩️ ¿Cómo se relaciona esto con la arquitectura Cloud?
El ejercicio permitió:
- **Dividir una aplicación grande** en partes pequeñas que funcionan juntas
- **Usar contenedores** que empaquetan cada parte de la aplicación  
- **Conectar servicios** que se pueden agregar o quitar según lo necesitemos
- **Mantener los datos** aunque reiniciemos los servicios

1. Qué mejoras implementaron.
2. Cómo se comunican los contenedores entre sí.
3. Cómo confirmaron la persistencia de datos.
4. Qué aprendieron sobre la modularidad y arquitectura cloud.


Preguntas para la reflexión final
1. ¿Qué diferencia hay entre un contenedor y una máquina virtual?
2. ¿Qué pasaría si se elimina el contenedor de MySQL pero no el volumen?
3. ¿Qué rol cumple el archivo docker-compose.yml en la orquestación de
servicios?
4. ¿Cómo se comunican los contenedores entre sí dentro de la red interna?
5. ¿Por qué es importante separar la aplicación web del motor de base de
datos?
6. ¿Qué ventajas tiene Docker frente a un hosting tradicional?
7. ¿Qué elementos del ejercicio serían equivalentes a servicios en AWS o
Azure?
8. ¿Cómo se evidenció el trabajo colaborativo dentro del equipo?