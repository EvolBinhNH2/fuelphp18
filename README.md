# fuelphp18
The Login sample used Google API Oauth2.0

## Apache config
<Directory "/var/www/fuelphp18">    
    Options FollowSymLinks Indexes    
    AllowOverride All    
    Order deny,allow    
    allow from All    
</Directory>    

## Apache config
<VirtualHost *:80>    
    ServerName fuelphp18.com    
    DocumentRoot "/var/www/fuelphp18/public"    
    #SetEnv APPLICATION_ENV development    
</VirtualHost>    

## Create Google API
https://console.developers.google.com/
Create project -> add access user & redirect link
copy Client ID and Client secret: credentials -> OAuth 2.0 client IDs -> 

## Config fuelphp
fuel\app\config\opauth.php

'client_id'     => '349382600450-pf6o6vpd2rj1a9me011pun9djs5fstng.apps.googleusercontent.com',    
'client_secret' => 'vPVvuv1oaGHjZCEdJYB6D6eq',    
