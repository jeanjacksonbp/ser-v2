# Configuração para XAMPP - SER v2

Para configurar corretamente o acesso sem /public/, você pode:


## Opção 1: Virtual Host (Recomendado)

1. Edite o arquivo: C:\xampp\apache\conf\extra\httpd-vhosts.conf

2. Adicione no final:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/ser-v2/public"
    ServerName ser.local
    <Directory "C:/xampp/htdocs/ser-v2/public">
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
```

3. Edite o arquivo: C:\Windows\System32\drivers\etc\hosts

4. Adicione a linha:
```
127.0.0.1 ser.local
```

5. Reinicie o Apache

6. Acesse: http://ser.local

## Opção 2: Usando por enquanto

Acesse diretamente: http://localhost/ser-v2/public/

O sistema está funcionando perfeitamente nesta URL.