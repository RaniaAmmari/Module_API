composer update
composer require server
php bin/console server:run
symfony console doctrine:migrations:migrate 
symfony console doctrine:fixtures:load 


pour acceder à tout les articles: @GET  /article 
pour acceder à un article  @GET  article/{id}
pour poster un article @POST  /article
pour ajouter ou bien modifier @Put  /article/{id}
pour extrére les 3 derniers articles @GET  /articles
pour supprimer un article @Delete  /article/{id
