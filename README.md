# Barangay Bulletin - Purok Genilla

Lab Activity 11 - Relationships, Eager Loading & Form Requests

**Student:** Red Isaac D. Genilla
**Course:** Full-Stack Web Development
**Framework:** Laravel 12

## Project Description

Barangay Bulletin - Purok Genilla is a Laravel web application
for viewing and publishing community announcements.

Residents can browse posts, search announcements, filter by
category or tag, and submit comments after logging in.

Users with an author profile can create new bulletin posts.

This activity builds on my Lab Activity 10 project by adding
Eloquent relationships, eager loading, Form Request validation,
authentication, and comment functionality.

## Features

- Display published bulletin posts
- Pinned announcements appear first
- Search posts by title
- Filter posts by category and tag
- Pagination with 7 posts per page
- Display author names and profiles
- Show comment counts on bulletin cards
- Display comments with resident names
- Allow logged-in residents to comment
- Allow authors to create and publish posts
- Save unpublished posts as drafts
- Validate forms using Form Request classes
- Show validation errors and preserve old inputs
- Prevent residents from creating posts
- Use eager loading to avoid N+1 queries
- Responsive interface using Tailwind CSS

## Personalization

- Site Title: Barangay Bulletin - Purok Genilla
- Kagawad: Red Genilla
- Kagawad Email: kagawad.genilla@bulletin.test
- Resident: Lola Genilla
- Posts Per Page: 7
- Custom Category: Events
- Pinned Post: Purok Genilla Clean-up Drive
- Personalized Date: September 15, 2026

## Categories

The application uses these five categories:

1. Announcement
2. Health
3. Peace & Order
4. Ayuda
5. Events

## Tags

The five seeded tags are:

1. Purok Genilla
2. Urgent
3. Libre
4. Schedule
5. Events

Posts can have multiple tags. Tags are connected to posts
through the post_tag pivot table.

## Seeded Login Accounts

### Kagawad Account

Email: kagawad.genilla@bulletin.test

Password: bulletin2026

This account has an author profile and can create bulletin posts
and submit comments.

### Resident Account

Email: lola.genilla@bulletin.test

Password: bulletin2026

This account can browse announcements and comment, but cannot
create bulletin posts.

Both accounts are sample accounts for this lab activity.

## Eloquent Relationships

### User and Author - hasOne / belongsTo

A User hasOne Author, while Author belongsTo User.

This relationship links a login account to an author profile.
It allows the application to determine whether a logged-in
user has permission to create posts.

### User and Comment - hasMany / belongsTo

A User hasMany Comments, while Comment belongsTo User.

This relationship identifies the resident who wrote a comment.

### Author and Post - hasMany / belongsTo

An Author hasMany Posts, while Post belongsTo Author.

This allows one author to create multiple bulletin posts.
The author_id foreign key identifies the author of each post.

### Post and Comment - hasMany / belongsTo

A Post hasMany Comments, while Comment belongsTo Post.

This allows residents to leave multiple comments on one post.

### Post and Tag - belongsToMany

Post and Tag both use belongsToMany.

The post_tag pivot table connects posts with tags.
The sync() method assigns selected tags to posts.

### Author and Comment - hasManyThrough

Author hasManyThrough Comment using Post.

This allows the author page to count all comments received
across the author's bulletin posts.

## Eager Loading

The application uses with(), load(), and withCount().

The bulletin listing eager-loads authors and tags and retrieves
comment counts.

The post detail page loads the author, tags, comments, and
the users who wrote those comments.

preventLazyLoading() is enabled during development to help
detect unnecessary lazy-loading queries.

## Database

The application uses SQLite.

A fresh seed creates:

- 5 authors
- 10 users
- 51 posts
- 41 published posts
- 10 drafts
- 5 tags
- Random comments on published posts

The pinned post receives 3 comments, including one from
Lola Genilla.

The new tables include comments, tags, and post_tag.
The authors table also receives a nullable user_id foreign key.

## How to Run

Requirements:

- PHP and Composer
- Node.js and npm
- SQLite support for PHP

1. Open a terminal in the project directory.

2. Install PHP dependencies:

   composer install

3. Copy the environment file:

   Windows PowerShell:
   Copy-Item .env.example .env

   Git Bash:
   cp .env.example .env

4. Generate the application key:

   php artisan key:generate

5. In .env, configure:

   DB_CONNECTION=sqlite

6. Create database/database.sqlite if it does not exist.

   In PowerShell:
   New-Item -Path database/database.sqlite -ItemType File

7. Run migrations and seeders:

   php artisan migrate:fresh --seed

8. Install frontend dependencies:

   npm.cmd install

9. Start Laravel:

   php artisan serve

10. Open another terminal and start Vite:

    npm.cmd run dev

11. Visit:

    http://127.0.0.1:8000/posts

## Routes

GET /posts - Browse published posts

GET /posts/{id} - View one published post

GET /authors/{author} - View author profile

GET /login - Login page

POST /login - Authenticate user

POST /logout - Logout

GET /posts/create - New post form

POST /posts - Store a new post

POST /posts/{post}/comments - Submit comment

## Technologies Used

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

