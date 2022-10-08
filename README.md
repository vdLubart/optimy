# Console News Manager

This console application helps to manage articles from the database. Application
may read the full list of articles and each of them separately. It provides
additional options to display output  in different views, helps add new article,
as well as remove the existing one.

## Installation

To make the application ready to use, do the following steps:

- clone the repository and navaigate to the source directory in your terminal
- create a database and insert the data from the `dbdump.sql` file
- install dependencies with `composer install`
- rename `.env.example` to `.env` file and update MySQL connection data inside.

That's it! The application is ready to go!

## Usage

To start use the application it is enough the type in the terminal:

`php console list`

You will see the full list of the available commands.

### Show the list of articles:

`php console news:show` shows the first article page

`php console news:show --page=2` shows the second article page

`php console news:show --ipp=2` shows first article page with two articles on the
page

`php console news:show --text` shows article page with descriptions

`php console news:show --full` shows article page with descriptions and comments

### Read a single article

`php console news:read 3` shows the description and comments for the third article
The article ID may be found in the `news:show` list

### Add new article

`php console news:add "Title" "Description"` adds the new article with the 
specified title and description

### Add new comment

`php console news:add-comment 2 "Comment"` adds a comment to the second article

### Delete article

`php console news:delete 3` deletes the specified article from the database.

## Disclaimer

Current implementation proposes the modern way of the console application
implementation. At the same time, the application follows the existing database
structure and accepts it as an input data. In the real-life application, the
database also should be refactored at least with using foreign-keys.
