#!/bin/bash

# Rodar scripts de inicialização se o container estiver subindo agora
# php /var/www/html/create_conf_table.php
# php /var/www/html/init_notifications.php
# php /var/www/html/init_es.php

# Iniciar o Apache em primeiro plano
exec apache2-foreground
