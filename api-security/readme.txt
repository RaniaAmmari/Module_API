composer update
composer require server
php bin/console server:run
symfony console doctrine:migrations:migrate 
symfony console doctrine:fixtures:load 

----Générer une clé publique et privée avec une passphrase à reporter dans le .env
modifier le mot de pass(JWT_PASSPHRASE) (le jwt existant est: rania123)
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
-----

pour ajouter un utilisateur dans la BD:
@POST("/user)
-----------
pour acceder à tout les articles public: @GET  /api/article 
pour acceder à un article  @GET  /api/article/{id}
pour poster un article @POST  /api/article
pour ajouter ou bien modifier @Put  /api/article/{id}
pour extrére les 3 derniers articles @GET  api/articles
pour supprimer un article @Delete api/article/{id
