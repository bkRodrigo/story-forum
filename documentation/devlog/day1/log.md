[back to main log](../log.md)

## Day 1

### Items to complete
* [ ] High level analysis of the project
* [ ] Get the local environment running
* [ ] Get general API docs running
* [ ] Clean up the code repository such that uneeded files can be pruned out
  (Laravel has lots of default files we don't want for an API)
* [ ] Let's check our work by allowing the API logging in and generating
  auth tokens

Ok, this is exciting... I wonder how laravel Sail has evolved in the last couple
of years... Before we get ahead of ourselves, let's think through this project a
bit.

### General design
We're building the messaging component of what sounds a lot like a web forum
app. The first question to ask here is;
> Laravel or Lumen?

Technically speaking, I think Lumen is probably appropriate for this use case
because I wouldn't implement the UI for this app in the same repository. I'm
just not a fan of monolithic fullstack applications. But, objectively speaking,
we don't have performance constraints that need to be measured in milliseconds
here... A well built Laravel app is only a few milliseconds slower than a
lumen app. I'm also in a big time crunch, I have a sample project that's built
on Lumen ([here](https://github.com/bkRodrigo/Contacts_API)) and I don't want to
colide with potential debugging issues on such a short project. I'll build this
sample project on Laravel in order to be able to safely leverage any ecosystem
tool that's available to me with Laravel; this is a POC after all.

#### High level project requirements
1. We need a relational database, the data here is clearly relational
2. We need an event system that supports debouncing
3. We need this to fully run locally

None of the above seem to be out of the ordinary. Perhaps the debouncing can be
somewhat tricky to implement, but I don't think I need to design for this
requirement, we can solve this problem when we get to it. Generally speaking,
this project needs to be;
* Horizontally scaleable (each node should be state-less)
* The system should support working in "job mode" and in "API mode". In order to
  do this, we need to be able to dispatch jobs and have them handled by nodes
  that are allowed to process jobs. We'll want a dedicated queue that's running
  on something like redis for this.
    * We'll think this through when we get to it, but we at least know that we
      need a queueing solution here.
* The API should be well thought out. We want it to be extensible and easy to
  use

#### Nice to haves
* I'd like to be able to have a UI that gets generated and describes the API.
    * Ideally, this API should be interactive via mocks
* I'd like this project to be able to export Postman collections
* I'd like to have full test coverage of each endpoint

**Recap**
Let's quickly highlight the specific design decisions that we're making here.
* We want to have nodes that run based on their assigned role. Available roles;
    * API: Gets API requests and processes them. Jobs that get dispatched by this
      service need to be fulfilled by a Job enabled node.
    * Job: Does not pay attention to API requests, probably lives in a private IP.
      this node will address all pending jobs. Jobs that get dispatched by this
      service can be fulfilled by the same node but _MUST_ be fulfilled by a node
      that has Jobs enabled.
* We want queues in order to correctly handle async tasks. We'll probably use
  redis as the state manager for queues here. We should also consider what type
  of redis server we want (thinking append only mode that auto prunes every day
  or something)
* We want to generate good API docs. I think I'm going to try to solve this
  problem first
* I don't think we need specific design decisions to support job debouncing. I'm
  sure there are plenty of job debounce libraries out there, but keeping the the
  spirit of expressing what "I can do", I'll create this library myself.

#### General proposed infra
* One small dedicated redis service
* One dedicated Jobs node
* One dedicated API node

_The above can either be individual machines or containers in our docker scheme.
For local development, we'll make them containers. We'll see what we can do for
deploy._

Let's move on, I think we have a general idea of how to do this

### Local environment
Goal here will be to get the local environment 100% running by only installing
the following in the host system;
* Git
* Curl
* Docker on the host system
* PHP code editor of choice

#### Dev env
Looks like the docs say that we can curl the files and execute them in bash.
This is great news :-D
```
curl -s "https://laravel.build/story-forum" | bash
./vendor/bin/sail up -d
```
The above like magic gives me a boiler plate app that I can visit at
http://localhost/, great!

#### Host machine
My host machine is a M1 Macbook (I prefer Linux but that's what I have atm). I
have a PHPStorm license, so let's install that. I also have some docs on
[configuring PHPStorm](./phpstorm-config.md) (I'm aware that I can
just have a config file, but it's nice to have documentation on how to customize
your IDE).

We definitely want to evolve this setup as we'll need
to configure our docker-compose to make the desired number of containers and the
desired configurations. For now, we'll keep the local dev environment as is.

### API docs
Let's start with api docs, I don't like how API docs are afterthoughts in many
projects. Let's try to get something nice before getting started

Here's what I want from my API doc
* I'd like my API doc to be interactive
* I'd like the API doc to export to Postman collections
* It needs to be simple to implement
* I'd like to get this done in 30 minutes (not much time)

#### We're definitely using a library for this
I did a quick search and I stumbled upon
[laravel-apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator).
This looks to pretty much solve everything I want but latest commit is from 2
years ago and there are issues that are more than 2 years old. This package is
not looking promising, next...

Next search resulted in [knuckleswtf/scribe](https://github.com/knuckleswtf/scribe).
Latest commit on this is yesterday! Issues seem to be getting addressed actively.
This is definitely more promising. How about the features? It has many features,
but most importantly, it supports what I'm trying to support;
* It generates a UI
* It has sample responses in the UI
* It exports to postman
  It checks out, let's go ahead and do this.

#### Install and initial config
```
sail composer require --dev knuckleswtf/scribe
sail artisan vendor:publish --tag=scribe-config
```

**Updates to the Scribe config**  
Looking at the docs, it looks like we need to decide if we want to use
authentication in order to access the API docs. Given that this is a POC I'm
going to skip needing auth for this. In real life, we'd want to have
authentication for the docs in order to have control over who can view our API
docs (not to mention that we might enable some request fetching which could
expose sensitive data).

Looking further, we want to update the docs url so that it's the root url. This
app has no UI so we might as well make the docs be the root url. We'll surely
add more configuration to scribe as we build this app but let's see what this
gives us;
```
sail artisan scribe:generate
```

We have a UI! We'll leave our API doc stuff here for now until we really get to
creating users and checking those endpoints. Let's move on for now...

### Clean up directories
Things we can remove
* Everything in the `/resources` directory (except what's generated by scribe)
* Our Routes directory;
    * We can get rid of the `/routes/web.php` file (which of course means we need to
      remove the service provider)
    * We won't use channels, so let's get rid of `/routes/channels.php`
* We don't need a `package.json` file
* We don't need a `vite.config.js` file either

There surely is more to remove here but we'll leave it like this for now, we
want to get started with the app itself.

## General thoughts about introducing dependencies
I added a dependency and will potentially add more dependencies to this project
as I see it through. Let's discuss the rationale for adding dependencies to a
project. It's important to know what you're signing up for when thinking about
introducing dependencies to a project. Here are some of the risks;
* A point of failure for when you upgrade the Laravel framework
* You can be stuck in a Laravel version due to a dependency not having released
  a version compatible with Laravel latest
* You are delegating a functionality so that another group can be concerned with
  maintaining the desired functionality. This means that you should be careful
  to evaluate the dependencies you're introducing such that you don't risk the
  stability of your project.

As a general rule of thumb, I usually don't mind looking at dependencies for
functionalities that don't block the core of a product. If we're introducing a
dependency that will block my project when it's not properly maintained, then
I'm very careful with deciding whether to add it or not.

The Laravel framework is a core dependency of this implementation. So my
questions when deciding to use Laravel would be (_besides it being a requirement
to this task_);
1. Does it have a release cadence?
2. Does it have good support and maintenance?
3. Does it tend to make breaking changes? If it does, is there an accessible
   upgrade path story?
    1. How long do I have before I'm forced to upgrade?
    2. Is there an LTS?
4. Is the framework open source?
    1. How big is the community?
    2. Is the project sustainable over time?

The point is that there are several questions that need to be asked when you're
staking the future of your application on a dependency (this includes the
framework that's getting leveraged). Without getting on too much of a tangent
here, I'll say that Laravel is generally a fine choice if you're going to use
something like the LAMP stack.

### That's it!
I ran out of time, I feel like it's a healthy amount of effort for `1` hour.
Here's the list of tasks and what was completed;
* [x] High level analysis of the project
* [x] Get the local environment running
* [x] Get general API docs running
* [x] Clean up the code repository such that uneeded files can be pruned out
  (Laravel has lots of default files we don't want for an API)
* [ ] Let's check our work by allowing the API logging in and generating
  auth tokens (slipped for Monday)

[back to main log](../log.md)
