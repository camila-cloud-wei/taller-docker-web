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

## 🌩️ ¿Cómo se relaciona esto con la arquitectura Cloud?
El ejercicio permitió:
- **Dividir una aplicación grande** en partes pequeñas que funcionan juntas
- **Usar contenedores** que empaquetan cada parte de la aplicación  
- **Conectar servicios** que se pueden agregar o quitar según lo necesitemos
- **Mantener los datos** aunque reiniciemos los servicios
