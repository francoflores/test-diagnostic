## Sobre esta Aplicación.
 Es una aplicacion para mostrar las habilidades técnicas que se poseen en el desarrollo de sofware.
 Principalmente con los lenguajes PHP.
 
 La aplicación es una API que permite dar de alta, modificar y/o eliminar un paciente.
  Tambien permite registrar los diagnosticos que ha tenido ese paciente, es decir, su historial medico.
 
 ## Tecnologías aplicadas.
 - Laravel 8
 - PHP 7.4
 - MySQL 14.14
 - Bootstrap 5
 - JQuery
 
 ## Instalación
 Configurar el ambiente, colocando las credenciales de base de datos en el archivo `.env`
 
 - `DB_CONNECTION=mysql`
 - `DB_HOST=127.0.0.1`
 - `DB_PORT=3306`
 - `DB_DATABASE=diagnostic`
 - `DB_USERNAME=root`
 - `DB_PASSWORD=password`
 
 Una vez configurado el archivo `.env` proceder a ejecutar los siguientes comandos
 
 Comandos a ejecutar
 
 - `composer install -vvv`
 - `php artisan db:create diagnostic`
 - `php artisan migrate` 
 
 ## Ejecutar la aplicacion
 Esto es un API que tiene varias endpoints desarrollados. Sin embargo tambien de desarrollo unas interfaces que interactuan con los endpoints
 
 Para ingresar a esa interface debe ejecutar el siguiente comando:
 
 `php artisan serve`
 
 Y podra ver la interface en el navegador a traves de la siguiente url:
 
 `http://localhost:8000`
 
 ## Contacto
 Si presenta algun problema con cualquier comando o con la ejecución de la aplicacion puede enviarme un mensaje al correo:
 `francofloresdelgado@gmail.com`
 
 ##