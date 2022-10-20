[back to day2 log](./log.md)

## Setup the user models and get an API authentication in place
In order for us to check that we're creating docs and our tests run as expected,
let's set up user authentication through the API and update the apidoc generator
so that we can see it running.
* We should be able to provide an API key for a FE implementation.
* I don't think this quick job requires us to use a package like passport. I'm
  pretty sure Laravel Sanctum already provides us with all the desired
  functionalities

Ok, we're making a user API in this little peace. What features do we need for
this to work?
* We need a mechanism for CRUD'ing users
* We need a way to login
* We need to fetch tokens

### CRUD'ing users
For this API, I'd like to restrict the scope. Although we have to be able to
create, update and delete users, I'm only going to make an endpoint for creating
a user, we need to save time on auth... auth is just not that special in general
(it's a solved problem).

#### Create a user
In order to create a user we need to build a few tests. This means that we have
to peak into the test config
**Noteworthy things**
* I don't want tests to require a full database sqlite should be enough
* Tests should refresh the test db
* We're only doing a JSON API, no _real_ support for a web app in this version

Using sqlite for testing the db is easy enough, but I built a convenience method
to make sure the db file exists
```
forum artisan db:boot-tests
# docker-compose exec app php artisan db:boot-tests
```
For the sake of neatness, I'll create dedicated controllers for each action, it
makes for easier to digest functionalities.

This was easy enough, created `App\Http\Controllers\User\StoreUser`, it's a
route that can be called as a guest

Most of this is pretty simple to do, suffice it to say that we did the following
* Create user endpoint with the following
  * endpoint: `/api/user`
  * Request type: POST
  * Body;
    * name (required): `string`
    * email (required): `string`
    * password (required): `string`
    * biography (optional): `string`
  * Returns: auth token
  * Tests created, yes [UserCreateTest.php](../../../tests/User/UserCreateTest.php)
* Get logged in user endpoint
  * endpoint: `/api/user/`
  * Request type: GET
  * Returns: `User`
  * Tests created, yes [LoggedInUserGetTest.php](../../../tests/User/UserGetTest.php)
* Get user
  * endpoint: `/api/user/{id}`
  * Request type: GET
  * Returns: `User`
  * Tests created, yes [LoggedInUserGetTest.php](../../../tests/User/UserGetTest.php)
* Login user
  * endpoint: `/api/login`
  * Request type: POST
  * Returns: auth token
  * Tests created, yes [LogInUserTest](../../../tests/User/LogInUserTest.php)

[back to day2 log](./log.md)
