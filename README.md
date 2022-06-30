# TV show forum

## Installation

You will need to install [docker and docker-compose](https://docs.docker.com/engine/install/ubuntu/) to install TV show forum.

To install the projet follow these commands :
```bash
git@github.com:M4g1kFlo/tvShowForum.git
```
```bash
cd tvShowForum
```
```bash
docker-compose run --rm composer install
```

Now you need to create the database :

- Create a file .env.local with this information (Adapt the datbase URL to your convenience)
    ```bash
    APP_ENV=dev
    DATABASE_URL="mysql://symfony:symfony@db:3306/db?charset=utf8mb4"
    ```
- Run you local environment
    ```bash
    docker-compose up -d
    ```
- Update the database
    ```bash
    docker-compose run --rm symfony console doctrine:migrations:migrate
    ```
    ```bash
    docker-compose run --rm symfony console doctrine:fixtures:load
    ```


- Now you can go to http://localhost:8000/, it's working !
## Usage

To log as an admin :

- username : admin
- password : admin1

To log as a user :

- username : user1
- password : user12

## Command
- To generate data use :
    ```bash
    docker-compose run --rm symfony console doctrine:fixtures:load
    ```
## License
[MIT](https://choosealicense.com/licenses/mit/)