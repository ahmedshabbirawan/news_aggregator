## News Aggregator

### Technology: PHP / Laravel / MySQL

This application is a job task that fetches data from external resource APIs and stores it in a database. Users can view detailed news articles and set their preferences for news sources and authors.

The project uses Laravel's nwidart module, with repository and feature-based classes.

## Project Setup

1. Clone the project repository.
2. Run `composer install`.
3. Set the environment variables with MySQL database credentials.
 `NEWS_API_KEY=ab8038e05e6b4ef9b984df26d86baffa`
 `NY_TIME_NEWS_API_KEY=HVX5xqobJ8I1wpGA1URWM4byWiFQblmF` 
4. Run the migrations: `php artisan migrate`.
5. Run the seeder: `php artisan db:seed`.

## API Endpoints

### Fetch the News
`{{BASE_URL}}/api/news-fetch`

### User Registration and Login
- Register: `{{BASE_URL}}/api/register`
- Login: `{{BASE_URL}}/api/login`

### News Retrieval (Requires User Login)
- Get all news: `{{BASE_URL}}/api/news`
- Get news details: `{{BASE_URL}}/api/news/{id}`

### User Preferences
- Get and set preferences: `{{BASE_URL}}/api/preferences`

### Postman Collection 
`https://gold-moon-347404.postman.co/workspace/New-Team-Workspace~d17c5fef-f3e1-4d38-b5c1-b508b1746745/collection/6149118-ae3c1fd8-3f9d-4a5c-97e9-43e9b967cd6b?action=share&creator=6149118`
