#Installation
- `composer install`
- Install the database (see vagrant-bootstrap/structure.sql)


##Notes
- Don't have composer?
`curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer`

#Environmental Variables
- DB_DATABASE: Database name
- DB_USERNAME: Database username
- DB_PASSWORD: Database password
- WEB_ROOT: Root of the project. If the web root isn't / set this as appropriate