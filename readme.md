# BAMBU B2B TEST
## TEST
- La aplicación consta de dos ejercicios, a continuación se describirán los servicios y modos de uso para montar el proyecto.

## Instalación
- PHP: 7.3
- Apache: 2.4.46 (Win64)
- MariaDB: 10.4.17
- jQuery v3.2.1
- Bootstrap v4.1.1

## Usabilidad
	- Clona o descarga el proyecto de este repositorio y muevelo hacia tu directorio del servidor web.
    - El nombre de la carpeta es b2b y esta contiene todo los archivos necesarios acorde al test descrito.
    - Los parámetros de conectividad hacia la base de datos se encuentran en /config/Database.php.
    - Posteriormente restaura la base de datos mediante el script "b2b.sql" que se encuentra en la raíz del proyecto.
    - Una vez realizado los pasos anteriores, ve a tu browser y en la barra de direcciones digita "http://localhost/b2b".
    - La interfaz de usuario muestra un nav con 2 opciones que son Ejercicio 1 y 2.
    - Se realizo el extra, considerar que en el extra las operaciones que estan relacionadas con los locales se demoran entre 3 a 5 segundos en el display de la data, por el cruce de información y la estructuración de los datos.
## A considerar
    - A futuro para no estar editando el archivo /config/Database.php, se debiese considerar un archivo ".env".
    - Con la finalidad de tener una mayor abstracción y protección de las clases y del código fuente y de esta manera, configurar variables de entorno como api_key, db_access, etc.



	