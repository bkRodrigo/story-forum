[back to main log](../log.md)

## Day 2 (_Monday_)
Order of business for today;
* [ ] Let's get a nice debounce logic for events working
* [ ] Send the email to the reviewers of this project!

I'm only going to put 1 hour into this today and that's the end of this project

### Let's do some debouncing!

I think all we need for this is an event that receives the following;
* A message id
* A user id

So that when a message is posted, events are scheduled to be dispatched in one
minute for all of the users involved in the associated thread.

Upon receiving the event, we need to do the following query;
* Is this the latest message in the thread?
  * **If not**: Do nothing, there's been a newer message in the last minute, the
    notifying will be handled by the next queued event
  * **If yes**: Notify all users associated to this thread

To achieve this, I would normally have my queue maintain state via redis; for
this sample project, I'll just use the database for job state management. I will
not create tests for this job implementation, there's just not enough time.

#### Let's get Queues working
```
forum artisan queue:table
# docker-compose exec app php artisan queue:table
forum artisan migrate
# docker-compose exec app php artisan migrate
forum artisan make:job NotifyNewMessage
# docker-compose exec app php artisan make:job NotifyNewMessage
forum artisan queue:work
# docker-compose exec app php artisan queue:work
```

I'll admit, this is definitely not a "production ready" queue. We just want to
get this out of the door.

### Things Completed today
* [x] Let's get a nice debounce logic for events working
* [x] Send the email to the reviewers of this project!

I really enjoyed doing this, took longer than I had hoped but I truly enjoyed it
Thanks very much!

---
You can find a bit of a retro at the end of the [README.md](../../../README.md#things-that-could-be-improved) :)

[back to main log](../log.md)
