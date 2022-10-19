[back to README](../../README.md)

# DevLog
We need to build something that looks like a Forum board. Requirements can be
viewed here:
[laravel-message-board-api](../laravel-message-board-api.md)

Ok, I'll start this off by mapping out my schedule. I'm supposed to take 4-5
hours to do this, and I'm too excited not to start on Sunday. I think I can
squeeze in 1.5 hours of work today; I'll do the remainder tomorrow.

## The Plan
Let's map this out day by day.
### Day 1 (_Sunday_)
I have something like `60` to `90` minutes I can invest in this project today.
Here's the order of business for the day
* High level analysis of the project [Completed on Day 1](devlog.md#day-1)
* Get the local environment running
* Get general API docs running
* Clean up the code repository such that uneeded files can be pruned out
  (Laravel has lots of default files we don't want for an API)
* Let's check our work by allowing the API logging in and generating
  auth tokens

[devlog for day 1](day1/log.md)

### Day 2 (_Monday_)
I should have something like 3 hours to invest in this project on Monday
* Let's check our work by allowing the API logging in and generating
  auth tokens
* Let's create the models for this project and whip up MySQL as the DB for
  this
* Let's flesh out the API
* Let's get a nice debounce logic for events working
* Let's make sure our docs are nice and clean
* Let's deploy this to live via Github actions

[devlog for day 2](./day2/log.md)

### Day 3 (_Wednesday morning_)
I'm only going to put in 30 minutes to button everything up and have a bit of a
retro on the experience of doing this challenge

## Improvements
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

[back to README](../../README.md)
