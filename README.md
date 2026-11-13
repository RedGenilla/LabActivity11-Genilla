# Barangay Bulletin - Purok Genilla

**Lab Activity 11:** Relationships, Eager Loading & Form Requests

**Student:** Red Isaac D. Genilla
**Course:** Full-Stack Web Development
**Framework:** Laravel 12

## Project Overview

Barangay Bulletin - Purok Genilla is a Laravel web application
for publishing community announcements.

Visitors can browse published posts, search announcements,
filter by category or tag, and view author profiles.

Logged-in residents can submit comments. Users with an author
profile can create and publish posts or save drafts.

This project extends Lab Activity 10 using additional Eloquent
relationships, eager loading, authentication, and Form Requests.

## Personalization

- Site Title: Barangay Bulletin - Purok Genilla
- Kagawad: Red Genilla
- Resident: Lola Genilla
- Posts Per Page: 7
- Custom Category: Events
- Pinned Post: Purok Genilla Clean-up Drive
- Personalized Post Date: September 15, 2026

## Categories

1. Announcement
2. Health
3. Peace & Order
4. Ayuda
5. Events

## Tags

1. Purok Genilla
2. Urgent
3. Libre
4. Schedule
5. Events

The pinned post has the Purok Genilla and Urgent tags.

## Features

- Published bulletin listing
- Pinned announcements shown first
- Search posts by title
- Category and tag filtering
- Pagination with seven posts per page
- Author profile pages
- Post view counter
- Comments and comment counts
- Resident login and logout
- Authenticated comment submission
- Kagawad-only post creation
- Published and draft posts
- Form Request validation
- Error messages and old input restoration
- Responsive interface using Tailwind CSS

## Seeded Login Accounts

### Kagawad Red Genilla

Email: kagawad.genilla@bulletin.test

Password: bulletin2026

Permissions:
- View announcements
- Submit comments
- Create published posts
- Save draft posts

### Lola Genilla

Email: lola.genilla@bulletin.test

Password: bulletin2026

Permissions:
- View announcements
- Submit comments
- Cannot create posts

These are sample accounts for this laboratory activity.

## Eloquent Relationships

### User

- author(): hasOne(Author)
- comments(): hasMany(Comment)

### Author

- user(): belongsTo(User)
- posts(): hasMany(Post)
- comments(): hasManyThrough(Comment, Post)

### Post

- author(): belongsTo(Author)
- comments(): hasMany(Comment)
- tags(): belongsToMany(Tag)

### Comment

- post(): belongsTo(Post)
- user(): belongsTo(User)

### Tag

- posts(): belongsToMany(Post)

These 11 relationship methods connect users, authors,
posts, comments, and tags.

The post_tag pivot table connects multiple tags to posts.
It uses a composite primary key.

## Eager Loading

The bulletin listing uses:

- with(['author', 'tags'])
- withCount('comments')

The individual post page uses load() for the author, tags,
comments, and comment users.

preventLazyLoading() is enabled during development to help
detect unnecessary database queries.

## Form Request Validation

### StoreCommentRequest

- User must be logged in
- Comment is required
- Minimum 3 characters
- Maximum 1000 characters
- Custom minimum-length validation message

### StorePostRequest

- User must have an author profile
- Title required, maximum 120 characters
- Body required, minimum 20 characters
- Category must be valid
- At least one tag required
- Tag IDs must exist in the database
- Publishing status must be boolean

### LoginRequest

- Email required and valid
- Password required

Forms use CSRF protection, validation error messages,
old input restoration, and checked checkbox restoration.

## Database and Seeding

The application uses SQLite.

Running migrations and seeders creates:

- 5 authors
- 10 users
- 51 posts
- 41 published posts
- 10 draft posts
- 5 tags
- Random comments on published posts

The pinned post receives three seeded comments,
including one from Lola Genilla.

The database contains:

- users
- authors
- posts
- comments
- tags
- post_tag

## How to Run

Open the project folder in VS Code.

Install PHP dependencies:

    composer install

Copy the environment file if it does not exist:

    Copy-Item .env.example .env

Generate the application key:

    php artisan key:generate

Set the following in .env:

    DB_CONNECTION=sqlite

Create database/database.sqlite if it does not exist:

    New-Item database/database.sqlite -ItemType File

Run migrations and seeders:

    php artisan migrate:fresh --seed

WARNING: This command resets the connected database.

Install frontend dependencies:

    npm.cmd install

Start Laravel:

    php artisan serve

Start Vite in another terminal:

    npm.cmd run dev

Open:

http://127.0.0.1:8000/posts

## Main Routes

GET /posts
GET /posts/{id}
GET /authors/{author}
GET /login
POST /login
POST /logout
GET /posts/create
POST /posts
POST /posts/{post}/comments

## Testing

Run the automated tests:

    php artisan test

Run the Lab 11 requirement tests:

    php artisan test --filter=Lab11RequirementsTest

Check routes:

    php artisan route:list

Compile Blade views:

    php artisan view:cache

Check migration status:

    php artisan migrate:status

Automated tests use the configured in-memory SQLite
testing database.

## Technologies

- Laravel 12
- PHP
- SQLite
- Eloquent ORM
- Blade Templates
- Tailwind CSS
- Vite
- Faker
- Git and GitHub

## Repository

https://github.com/RedGenilla/LabActivity11-Genilla

## Author

Red Isaac D. Genilla


