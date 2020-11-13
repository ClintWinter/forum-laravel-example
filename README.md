# Forum Sample Project

A sample project to showcase TailwindCSS, AlpineJS, Laravel, and Livewire.

## Questions

- rate limiting in Livewire?
- best way to handle cached data and pass into views?

## TODO

- [x] add testing for notifications
- [x] test "hot" on the front-end
- [x] find a way to implement Redis + Queues
    - [x] add Redis
    - [x] turn "CommentPosted" notification into queueable
    - [x] add "mail" as delivery channel
        - [x] verify emails in mailtrap
- [ ] ***!! figure out how to use rate limiting in Livewire !!***
- [ ] work through some of the questions in Learning Goals
- [ ] study/use magic methods & higher-order methods
- [ ] create scenarios to use design patterns outside of this project
    - [ ] observer
    - [ ] decorator
    - [ ] singleton
    - [ ] facade
    - [ ] proxy

also:
- added separate testing database
- added redis
- figured out vscode terminal to use
    - laragon's path for php.ini
    - redis-cli
    - queue workers
- added mailtrap support

### Features

**Posts**
- [x] index
- [x] show
- [x] add
- [x] edit
- [x] delete
- [ ] markdown formatting
- [ ] upvote/downvote + score tracking
- [x] authentication for actions
- [x] test coverage
    - [x] livewire tests
    - [x] unit tests
    - [x] http/route tests

**Comments**
- [x] index
- [x] add
    - [x] dynamically w/Livewire
- [x] edit
    - [x] dynamically w/Livewire
- [x] delete
    - [x] soft deletes to preserve comment structure
    - [x] dynamically w/Livewire
- [ ] markdown formatting
- [x] nested comments
- [x] collapsible threads (like reddit)
- [x] upvote/downvote + score tracking
- [x] authentication for actions
- [x] test coverage
    - [x] livewire tests

**Users**
- [ ] show
    - [ ] posts
    - [ ] comments
    - [ ] like score
- [x] auth
    - [x] Login
    - [x] Logout
    - [x] Register
- [x] notification dropdown
    - [x] event that notifies when comments are posted (for original poster and parent comment owner)
    - [/] WRITE TESTS FOR THIS
- [ ] throttle # of posts/comments per hour

&nbsp;

## Learning Goals

- **(Yes)** Experienced building API's (Oauth, Http::class, Webhooks)
- **(Yes)** TailwindCSS, Livewire, Blade
- **(Some)** TDD Experience
- Very good understanding of Laravel and it's Concepts/Tools
    - **(2)** Eloquent/Models
        - polymorphic relationship
    - **(2)** Authorization
        - where do yo put the gate definitions
        - where does the actual authentication logic live
        - where do you do the autorization
    - **(2)** Validation
        - displaying validation errors on the page
        - where do you validate
        - have you used custom validation classes
        - how do the errors get into the view?
    - **(2)** Service Providers
    - **(2)** Events
        - what should events be used for
        - why are they good
    - **(2)** Notifications
        - where and how should you use notifications, custom channels?
    - **(3)** Controllers
        - RESTful or not?
        - Route::resource or explicit?
    - **(1)** Queues
        - Do you understand the main reason to use a queue
        - what do you use a queue for
    - **(1)** Magic Methods
    - **(0)** Higher Order Methods/Proxies
- Intuitive understanding of how systems work
    - **(2)** Identifying concepts and translating them into Code Entities
    - **(2)** Identify which concepts are in charge of which decisions/actions
    - **(1)** Design Patterns
    - **(1)** Iterative Process Mentality (MVP)

***

## Notes

### Be super clear with naming your tests
before:
`adding_comment_is_required_and_must_be_5_characters_minimum`

after:
`comment_body_is_required_and_must_be_5_characters_minimum`

### Test what we actually care about
We originally were testing the `isHot` method directly on a post, but we don't actually care about that. We care that posts that are hot have an icon in the list of posts. That's what we should ultimately test.

### Take advantage of higher-order methods
before:
``` php
return $this->reactions->sum(function($reaction) {
    return $reaction->value;
});
```

after:
``` php
return $this->reactions->sum('value');
// or
return $this->reactions->sum->value;
```

### Naming events and notifications
It's okay if event/notification names overlap since they are so similar, but properly alias when necessary so they are clear.

before, PHP namespace resolver defaulted to:
``` php
use App\Events\CommentPosted;
use App\Notifications\CommentPosted as NotificationsCommentPosted;
```

we changed it to:
``` php
use App\Events\CommentPosted;
use App\Notifications\CommentPosted as CommentPostedNotification;
```

### Learned some AlpineJS order of operations
In a dropdown with `@click.away` on the container and `@click` on the button, it first executes the button `@click` and then the `@click.away` event. That means the button does not need to toggle open/closed for the dropdown because `@click.away` will catch it.

before:
```html
<div x-data="{open:false}">
    <button
        @click="
            if (open) $wire.clearNotifications();
            open = !open;
        "
    >Trigger</button>

    <section
        x-show="open"
        @click.away="
            if (open) $wire.clearNotifications();
            open = false;
        "
    >This is the dropdown container</section>
</div>
```

In the above example, we are doing more work than necessary because of a lack of understanding of the order of operations. `@click.away` will execute when the dropdown is showing and we click outside of the dropdown. That includes clicking the button. When clicking the button to close the dropdown, first the button's `@click` will execute, then the dropdown's `@click.away`.

What we have above is button's `@click` trying to do what the dropdown's `@click.away` will already handle because we don't know how it works.

after:
```html
<div x-data="{open:false}">
    <button
        @click="open = true"
    >Trigger</button>

    <section
        x-show="open"
        @click.away="
            $wire.clearNotifications();
            open = false;
        "
    >This is the dropdown container</section>
</div>
```

If you're asking how the button can close the dropdown when `open` is set to `true` every time, remember the order of operations. Whenever the dropdown is showing, `@click.away` will execute when we click the button AFTER the button's `@click`. So we click the button with the dropdown open and in `@click`, `open` stays `true`. Then in `@click.away` we clear the notifications and set `open = false` to close it. This is also nice because now we have one place to handle closing the dropdown along with any associated actions. Before, we would have tried to handle clearing notifications in the button event and the dropdown's click away event by using if statements to check the status of `open`.
