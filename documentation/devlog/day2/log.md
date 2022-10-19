[back to main log](../log.md)

### Day 2 (_Monday_)
Order of business for today;
* [ ] Let's check our work by allowing the API logging in and generating
  auth tokens (carry on from yesterday)
* [ ] Let's create the models for this project and whip up MySQL as the DB for
  this
* [ ] Let's flesh out the API
* [ ] Let's get a nice debounce logic for events working
* [ ] Let's make sure our docs are nice and clean
* [ ] Let's deploy this to live via Github actions

### Some grunt work first
Let's actually review our docker config
```
sail artisan sail:publish
```
Ok, there's a lot here... It's too much for this project. I really only want the
following service;
* app: for app logic
* db: for data storage
* nginx: for accepting requests

I'll want a redis service as well, but we'll leave that for later. I think I'll
just build my own docker boiler plate here as Laravel is just giving me too much
out of the box, there's something like 5 services here and they have too much
visual bloat for me to process.

So, I quickly whiped up a Dockerfile for my app server that supports PHP 8.1 and
has the DB connection config out of the box. The other two services I mentioned
can just be grabbed out of dockerhub wholesale (which I did). I did change some
things around. I made my app map to localhost:8080 on the host (it just feels
right to do it this way on the host).

My docker config kind of broke my `sail` command... doing `sail artisan` is no
longer possible; I have to do `docker-compose exec app php artisan`. This is
easy to fix by adding the following aliases;
```
alias forum='docker-compose exec app php'
alias dc='docker-compose'
alias dc-exec='docker-compose exec app'
```
Now I can;
* Build: `dc build app`
* Stop the daemon: `dc down`
* Create the daemon: `dc up -d`
* See the status: `dc ps`
* Run composer install: `dc-exec composer install`
* Artisan commands: `forum artisan`

We'll continue playing around with this as we go but laravel sail is really just
a cool thing that executes stuff in the container for us.

With the grunt work out of the way, let's continue with our user API

### User API
[user api logs](./user-api.md)

### Threads API
[thread api logs](./thread-api.md)


### Things Completed today
* [x] Let's check our work by allowing the API logging in and generating
  auth tokens (carry on from yesterday)
* [x] Let's create the models for this project and whip up MySQL as the DB for
  this
* [ ] Let's flesh out the API
* [ ] Let's get a nice debounce logic for events working
* [ ] Let's make sure our docs are nice and clean
* [ ] Let's deploy this to live via Github actions

[back to main log](../log.md)
