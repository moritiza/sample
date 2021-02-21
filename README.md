# Sample
## About
This is a simple test case  
This project is a simple api.


## How can I run it?
### #1 Execute composer install command in DocumentRoot directory
```bash
composer install
```

### #2 Make sure the docker is installed
```bash
docker --version
```
##### If the docker is not installed, you can use this link
<a href="https://docs.docker.com/engine/install/">Install Docker</a>

### #3 Make sure the docker service is running
```bash
sudo systemctl start docker.service
```

### #4 Execute docker-compose build command
```bash
sudo docker-compose build webserver --no-cache
```

### #5 Execute docker-compose up command
```bash
sudo docker-compose up --force-recreate
```

### #6 Make sure everything is OK! :wink:
##### Send request to 'http://localhost/api/ping' and you must receive 'pong'
```bash
curl -X GET "http://localhost/api/ping" -H "Accept: application/json"
```


## How can I dive into?
### Just import `Sample.postman_collection.json` and enjoy it! :smile:

  
## How can I test it?
### #1 Get into Docker container shell
```bash
sudo docker exec -it webserver bash
```

### #2 Execute artisan command
```bash
php artisan test
```