# Forum Sample Project

A sample project to showcase TailwindCSS, AlpineJS, Laravel, and Livewire.

## TODO

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
- **(No)** TDD Experience
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
    - **(0)** Events
        - what should events be used for
        - why are they good
    - **(1)** Notifications
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
