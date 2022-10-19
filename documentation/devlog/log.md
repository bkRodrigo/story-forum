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

[back to README](../../README.md)
