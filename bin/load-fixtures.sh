rm var/data.db -f && bin/console doctrine:schema:update --force
bin/console user:create tt@example.com tt
bin/console user:create admin@example.com admin
bin/console role:create ROLE_USER
bin/console role:create ROLE_ADMIN
bin/console user:role:add admin@example.com ROLE_ADMIN
bin/console user:role:add tt@example.com ROLE_USER
bin/console doctrine:fixtures:load --append
