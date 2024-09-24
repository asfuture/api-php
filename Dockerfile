# Usar a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Copiar o código da API PHP para o diretório root do Apache
COPY . /var/www/html/

# Conceder as permissões apropriadas para o diretório de trabalho
RUN chown -R www-data:www-data /var/www/html

# Expor a porta 80 para acessar a aplicação no navegador
EXPOSE 80
