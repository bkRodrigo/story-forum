# Code Challenge
## Messaging Forum API

Thank you for taking the time to look at this project! Please note that there
is a `documentation` directory on this repository. In the `documentation` directory
you'll find
* [project Reqs](./documentation/laravel-message-board-api.md): Full doc describing
  the project reqs
* [my Devlog](./documentation/devlog/log.md): In my devlog you'll see what I did during
  each of the 3 days of work

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

# Generate key
docker-compose exec app php artisan key:generate

# Migrate data
docker-compose exec app php artisan migrate

# Generate apidoc
docker-compose exec app php artisan scribe:generate

# Enable the tests
docker-compose exec app php artisan db:boot-tests

# Run the tests
docker-compose exec app vendor/bin/phpunit
```

### Test the demo env!
Go to http://sh01.brewkrafts.com/ in order to see some API docs
You can checkout my Postman collection [here](documentation/Story-Forum.postman_collection.json)
The web page also has a postman collection but I have not verified that it
works, if you're curious: http://sh01.brewkrafts.com/.postman

### Things that could be improved
Here's a list of things I would've liked to improve;
* It would be best to use UUIDs in order to specify entity ids
* It would be best to have a better structure for the tests (feature vs unit
  tests)
    * There's a lot of repeated code in the tests as well
    * Some tests are just incomplete and not sufficiently comprehensive
* It would probalby be better to build this on laravel Lumen, I found a lot of
  bloat in Laravel for a service.
    * Laravel Sail does waaay more than I wanted it to do, I ended up getting rid
      of it
    * Docker compose configs were too much for this service, Lumen might have
      simpler boilerplate
* General review of code and refactor. It's always good to refactor code a bit,
  time did not allow
* Complete the API. The reqs had an incomplete API, I would've liked to have a
  complete API here
* The resource responses should definitely be paginated. We can do this but just
  didn't have time
* Resource eager loading should be configurable. My Contacts_API sample project
  has pagination and optional eager loading ([peak](https://github.com/bkRodrigo/Contacts_API/blob/main/app/Http/Controllers/ResourceAbstractClass.php#L55)).
    * As with all sample projects, this one also has things that can be improved
* The possibility to have nodes that only do jobs and nodes that only take on
  requests; I just didn't have time to do this
* Deploy this to something like Github actions... just not enough time
* I would've liked to use API keys here instead of just auth tokens. We should
  be able to support any type of client. App clients might also need different
  ACL rules
* Policies!!! We definitely could've explored building good policies for this
* I also didn't have time to verify that my api docs worked as expected
* I would've liked to also make some good deploy docs
* Definitely would've wanted my demo server to have LetsEncrypt certs :-D
  
I hope you enjoy this project!
