# SER v2 - Configuração para desenvolvimento local

Para acessar o projeto corretamente, você tem duas opções:

## Opção 1: Acessar diretamente via public/
Acesse: http://localhost/ser-v2/public/login

## Opção 2: Configurar Virtual Host (Recomendado)

1. Abra o arquivo de hosts do Windows:
   C:\Windows\System32\drivers\etc\hosts

2. Adicione esta linha:
   127.0.0.1 ser.local

3. Crie um arquivo de configuração no Apache (XAMPP):
   C:\xampp\apache\conf\extra\httpd-vhosts.conf

4. Adicione esta configuração:

<VirtualHost *:80>
    ServerName ser.local
    DocumentRoot "C:/xampp/htdocs/ser-v2/public"
    <Directory "C:/xampp/htdocs/ser-v2/public">
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
    ErrorLog "logs/ser_error.log"
    CustomLog "logs/ser_access.log" combined
</VirtualHost>

5. Reinicie o Apache no XAMPP

6. Acesse: http://ser.local/login

## Para teste rápido agora:
Acesse: http://localhost/ser-v2/public/login