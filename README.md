# Code Challenge
## Messaging Forum API

Thank you for taking the time to look at this project! Please note that there
is a `documentation` directory on this repository. In the `documentation` directory
you'll find
* [project Reqs](./documentation/laravel-message-board-api.md): Full doc describing
  the project reqs
* [my Devlog](./documentation/devlog/log.md): In my devlog you'll see what I did during
  each of the 4 full days of work
* [local env](./documentation/deploy/local.md): Here you'll find detailed instructions
  on getting the dev env running.

## Running locally
### Requirements
* Docker
* Docker compose
* Git

### Before building
#### Docker config
Please keep in mind that this app will run in docker and that the web server will be
mounted to the port that you specify [here](https://github.com/bkRodrigo/story-forum/blob/main/docker-compose.yml#L39)
(by default, it maps to port 8080 of the host).

#### Env
Create a `.env` file and configure as required (not changing anything will work)
```
cp .env.example .env
```

### Getting local env running
```
# Build the docker image
docker-compose build app

# Start the daemon
docker-compose up -d

# Stop the daemon
docker-compose down

# Run composer install
docker-compose exec app composer install


```

  
I hope you enjoy this project!
