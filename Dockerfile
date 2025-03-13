# Usa l'immagine ufficiale PHP con Apache
FROM php:8.1-apache

# Installa le estensioni necessarie
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia il codice del progetto nella cartella del web server
COPY . /var/www/html/

# Espone la porta 80 per il web server
EXPOSE 80

# Avvia Apache
CMD ["apache2-foreground"]
