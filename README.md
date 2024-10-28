# CAMPBUK API

This project provides the API backend for the CAMPBUK super-app, developed using Laravel 8 and Laravel Sanctum for API authentication. The API enables user registration, authentication, profile management, blog post creation, commenting, and liking posts/comments.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)

## Features

- **User Authentication**: Register, login with Laravel Sanctum, delete an account.
- **User Profile Management**: View, edit, and delete the user profile.
- **Blogging Module**:
  - Create, edit, and delete blog posts.
  - Comment on blog posts.
  - Like posts and comments (each item can only be liked once per user).
  - Fetch all posts created, commented on, or liked by the user.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/RonaldoMine/campbuk-api
   cd campbuk-api
   ```
2. **Install the dependencies**
   ```bash
   composer install
   ```
2. **Configure the project**
   ```bash 
   cp .env.example .env
   php artisan key:generate
   ```
3. **Database Migrations**
   ```bash
   php artisan migrate
   ```
## Running the Application
   ```bash
   php artisan serve
   ```
## API Endpoints
The postman collection has been created, download the file and import the collection in postman. [Postman Collection](Campbuk_API.postman_collection.json)
