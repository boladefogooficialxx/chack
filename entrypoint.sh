#!/bin/bash

# Rodar scripts de inicialização se o container estiver subindo agora
# php /var/www/html/create_conf_table.php
# php /var/www/html/init_notifications.php
# php /var/www/html/init_es.php




#!/bin/bash
set -e

# Disable conflicting MPMs at runtime
a2dismod mpm_event mpm_worker || true
a2enmod mpm_prefork || true

# Execute the original entrypoint (apache2-foreground)
exec apache2-foreground

