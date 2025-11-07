# Deploy em Produção — Projeto SER

Este guia padroniza a instalação em produção (Linux, Apache/Nginx, PHP 8.x, MySQL/MariaDB).  
A **document root** do site deve apontar para `public/`.

---

## 1) Requisitos do servidor
- SO: Ubuntu 22.04+ (ou equivalente)
- PHP: 8.2/8.3 com extensões: `pdo_mysql`, `mbstring`, `curl`, `json`, `openssl`, `intl`, `zip`
- Banco: MySQL 8.x **ou** MariaDB 10.6+
- Web server: **Apache** (mod_php ou php-fpm) **ou** **Nginx** + php-fpm
- Composer 2.x
- Certificado TLS (Let’s Encrypt/Cloudflare)

---

## 2) Variáveis de ambiente
Crie `/.env` a partir de `/.env.production.example` (não versionar `.env` reais):
```env
APP_ENV=production
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=ser_prod
DB_USER=ser_user
DB_PASS=********

BASE_URL=https://ser.suaempresa.com
```

---

## 3) Preparar o código no servidor
```bash
# 3.1 — criar diretório da app
sudo mkdir -p /var/www/ser
sudo chown -R $USER:$USER /var/www/ser

# 3.2 — clonar e instalar dependências
cd /var/www/ser
git clone https://github.com/SEU-USUARIO/ser-v2.git .
git checkout main

# Composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --prefer-dist --optimize-autoloader

# .env
cp .env.production.example .env
nano .env   # ajustar credenciais e BASE_URL
```

---

## 4) Banco de dados
Criar schema e usuário (uma vez):
```sql
CREATE DATABASE ser_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ser_user'@'localhost' IDENTIFIED BY 'SENHA_FORTE';
GRANT ALL PRIVILEGES ON ser_prod.* TO 'ser_user'@'localhost';
FLUSH PRIVILEGES;
```

Aplicar scripts (na ordem):
```bash
mysql -u ser_user -p ser_prod < database/sql/01_schema_up_mysql8.sql   # ou 01_schema_up_mariadb.sql
mysql -u ser_user -p ser_prod < database/sql/02_seed_data.sql
mysql -u ser_user -p ser_prod < database/sql/04_auth_mvp.sql
```

> Nova versão com mudanças no BD deve trazer `NN_nome_migracao.sql`. Execute antes de subir a app.

---

## 5) Servidor Web

### 5.1 Apache (vHost)
Arquivo `/etc/apache2/sites-available/ser.conf`:
```apache
<VirtualHost *:80>
  ServerName ser.suaempresa.com
  DocumentRoot /var/www/ser/public
  <Directory /var/www/ser/public>
    AllowOverride All
    Require all granted
    DirectoryIndex index.php
  </Directory>
  ErrorLog ${APACHE_LOG_DIR}/ser_error.log
  CustomLog ${APACHE_LOG_DIR}/ser_access.log combined
</VirtualHost>
```
Ativar e recarregar:
```bash
sudo a2enmod rewrite
sudo a2ensite ser.conf
sudo systemctl reload apache2
```

### 5.2 Nginx + PHP-FPM
Arquivo `/etc/nginx/sites-available/ser`:
```nginx
server {
  server_name ser.suaempresa.com;
  root /var/www/ser/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
  }

  # proteger arquivos sensíveis
  location ~* \.(env|yml|yaml|ini|log|sql)$ { deny all; }

  access_log /var/log/nginx/ser_access.log;
  error_log  /var/log/nginx/ser_error.log;
}
```
Ativar e recarregar:
```bash
sudo ln -s /etc/nginx/sites-available/ser /etc/nginx/sites-enabled/ser
sudo nginx -t && sudo systemctl reload nginx
```

### 5.3 `.htaccess` (se usar Apache)
Coloque em `public/.htaccess`:
```apache
Options -Indexes
DirectoryIndex index.php

<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^ index.php [QSA,L]
</IfModule>
```

---

## 6) Permissões de pastas
```bash
sudo chown -R www-data:www-data /var/www/ser
# se usar diretórios de cache/temp/uploads:
sudo mkdir -p storage/cache storage/logs
sudo chown -R www-data:www-data storage
sudo find storage -type d -exec chmod 775 {} \;
sudo find storage -type f -exec chmod 664 {} \;
```

---

## 7) Otimizações
- `composer install --no-dev --optimize-autoloader`
- Habilitar **opcache** no PHP (php.ini)
- Gzip/Brotli no Nginx/Apache
- Cache de estáticos (CSS/JS) com cabeçalhos de expiração

---

## 8) Segurança
- TLS (Let’s Encrypt):
  ```bash
  sudo snap install certbot --classic
  sudo certbot --nginx -d ser.suaempresa.com   # ou --apache
  ```
- Bloquear acesso a `.env`, `.sql`, logs (Nginx location deny / Apache FilesMatch)
- Usuários do BD com privilégio mínimo
- Rotacionar senhas/tokens ao trocar de ambiente

---

## 9) Logs & monitoramento
- Logs do app (ex.: `storage/logs`)
- Tabela `audit_logs`
- Logs do web server (`/var/log/nginx` ou `apache2`)
- Healthcheck: criar `/public/healthz` que retorna `200 OK`
- Monitoramento: UptimeRobot/Healthchecks

---

## 10) Deploy contínuo (opcional)
- GitHub Actions: build, lints/tests, gerar pacote
- Deploy por SSH/rsync:
```bash
rsync -avz --delete --exclude .env --exclude vendor   ./ ser@servidor:/var/www/ser
ssh ser@servidor "cd /var/www/ser && php composer.phar install --no-dev --prefer-dist --optimize-autoloader"
```
- Executar migrações SQL antes de ativar nova versão

---

## 11) Checklist de Go-Live
- [ ] `BASE_URL` correta (https)
- [ ] TLS válido e redirect HTTP→HTTPS
- [ ] DocumentRoot em `public/`
- [ ] `APP_DEBUG=false`
- [ ] Permissões de pasta ok
- [ ] Migrações SQL aplicadas
- [ ] Usuário admin criado e login testado
- [ ] Healthcheck responde 200
- [ ] Backup do banco agendado (mysqldump + retenção)
