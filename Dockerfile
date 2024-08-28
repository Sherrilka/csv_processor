# Použije základní obraz s PHP
FROM php:8.2-apache

# Zkopíruje všechny soubory z aktuálního adresáře do /app v kontejneru
COPY . /var/www/html/

EXPOSE 80

# Spustí příkaz php když se kontejner spustí
CMD ["apache2-foreground"]
