I wasn't able to implement all of the bonus features, I only managed to do some.

The bonus points that I have managed to do are the following
- Implement a search feature that allows users to search for products by name or description
  - I implemented this one by using a search parameter as a request for the searched products, the search parameter will accept a string, that string will serve as a value when searching for a specific product by name or description. By default, if the search parameter is not set or empty, it will return the paginated products, else, it will return the product that matched the search query.

- Implement pagination for product and order listings.
  - I just use the built-in pagination function of the model to paginate the the order and product listings.


Note:
- I use the latest version of Laravel 8 (version 8.75)
- I have added the SQL schema, it is inside the folder "sql-schema", the sql file named "sevron-exam".
- Migration files are also added and can be migrated by the php artisan command.
