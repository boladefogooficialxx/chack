#!/bin/bash
set -e

# Disable conflicting MPMs at runtime
a2dismod mpm_event mpm_worker || true
a2enmod mpm_prefork || true

# Execute the original entrypoint (apache2-foreground)
exec apache2-foreground
