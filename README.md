Subscription system
-------------------
-------------------
How to install
-----------------
1. Run composer install by running ```composer install```
2. copy the .env.example to .env by running ```cp .env.example .env```
3. Add encryption key by running ```php artisan key:generate```
4. Add email details in the .env mailing section
5. Run migration by running ``` php artisan migrate```
6. Seed the database by running ```php artisan db:seed```
7. Serve the app by running ```php artisan:serve```
8. Install supervisor
9. Run the queue.sh file to create a background queue worker by running ```chmod +x queue.sh``` then running ```./queue.sh```
10. Subscribe a user by making a post request to /api/subscribe with payload ```{ email:"user@email.com",website_id:"1"}```
11. Add a website post by making http post request to /api/post with payload ```{title:"title",description:"description",website_id:"1"}```