Setup Guide : 
- Clone the project from the repository. 
- Install the composer in the project directory. (composer install) 
- Make the .env file by copying the .env.example file. 
- Generate the unique application key in .env. (php artisan key:generate) 
- Migrate the tables. (php artisan migrate) 
- Seed the tables. (php artisan db:seed) 
- Install npm or yarn dependency manager. (npm install OR yarn install) note: yarn prefered 
- To compile all the CSS and JS file execute the command. (npm run dev OR yarn run dev) 

API Setup Guide : 
- php artisan passport:install 
- php artisan passport:client --password
