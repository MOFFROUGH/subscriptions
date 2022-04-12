# subscription system
## how to install
1. Run composer install
2. copy the .env.example to .env
3. Add encryption key by running php artisan key:generate
4. Add email details in the .env mailing section
5. run migration 
6. seed the database
7. Serve the app
8. Install supervisor
9. run the queue.sh file to create a background queue worker
10. Subscribe a user via /api/subscribe
11. Add a post via /api/post
12. 