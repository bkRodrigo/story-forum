[back to day2 log](../log.md)

## Let's create the entities
Entities is just a matter of running a couple of artisan commands
```
forum artisan make:model Thread -mf
forum artisan make:model Message -mf
# docker-compose exec app php artisan make:model Thread -mf
# docker-compose exec app php artisan make:model Message -mf
```
Then updating the migrations to associate the appropriate constraints

As far as the endpoints are concerned, we'll go ahead and create them. We'll
leave the notifications scheme for later on.
* Create a thread endpoint: will associate the thread to the user that's
  attached to the auth token
  * endpoint: `/api/thread`
  * Request type: `POST`
  * Body;
    * title (required): `string`
  * Returns: `Thread`
  * Tests created, yes [ThreadTest.php](../../../tests/Thread/ThreadTest.php)
* Get user's threads endpoint: will get the threads associated to the user
  that's attached to the auth token
  * endpoint: `/api/thread`
  * Request type: `GET`
  * Returns: `Thread[]`
  * Tests created, yes [ThreadTest.php](../../../tests/Thread/ThreadTest.php)
* Get all of the messages associated to a thread. I know the req was requesting
  a collection of threads but it seems to be cleaner to just eager load the
  messages associated to a thread
  * endpoint: `/api/thread/{id}`
  * Request type: `GET`
  * Returns: `Thread` (it eager loads the messages in the thread)
  * Tests created, yes []
  * Tests created, yes [ThreadTest.php](../../../tests/Thread/ThreadTest.php)
* Create thread message: will create a message and associate it to the user
  that's attached to the auth token
  * endpoint: `/api/message`
  * Request type: `POST`
  * Body;
    * body (required): `string`
    * thread_id (required): `int`
  * Returns: `Message`
  * Tests created, yes [MessageTest.php](../../../tests/Message/MessageTest.php)
* Update thread message: Overwrites the body of the specified message
  * endpoint: `/api/message/{id}`
  * Request type: `PUT`
  * Body;
    * body (required): `string`
  * Returns: `200`
  * Tests created, yes [MessageTest.php](../../../tests/Message/MessageTest.php)
* Search messages: If no query strings are provided, then this returns all of
  the messages associated to the user that's attached to the auth token
  * endpoint: `/api/message`
  * Request type: `GET`
  * Query strings
    * thread_id=`int` (optional)
    * term=`string` (optional)
  * Tests created, yes [SearchMessageTest.php](../../../tests/Message/SearchMessageTest.php)

[back to day2 log](../log.md)
