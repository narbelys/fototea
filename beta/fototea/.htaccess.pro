RewriteEngine On
Options +FollowSymLinks -Indexes

<IfModule mod_rewrite.c>
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

#RewriteRule ^actions/ actions.php [NC,L]    # Handle requests for "pet-care"

RewriteRule ^(.*)$ index.php?q=$1   [L,QSA]
#RewriteRule horses.htm actions.php [L]
#RewriteRule ^([a-z0-9]+)$ index.php?s=$1 [L,QSA]
RewriteRule ^actions/(.*)$ actions/router.php?action=$1 [L,QSA]
</IfModule>


#-- Previene XSS y ciertas manipulaciones de direcctorios
 RewriteCond %{REQUEST_METHOD} GET
 RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=http:// [OR]
 RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=(\.\.//?)+ [OR]
 RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=/([a-z0-9_.]//?)+ [NC]
 RewriteRule .* - [F]

#-- Deshabilita el acceso a ciertos directorios
 RewriteRule ^(views)/ - [R=404]
 RewriteRule ^(sql)/ - [R=404]

 ErrorDocument 404  http://www.fototea.com
 ErrorDocument 403  http://www.fototea.com

<Files libSM.php>
Order allow,deny
Deny from all
</Files>

php_value upload_max_filesize 10M
php_value post_max_size 10M

