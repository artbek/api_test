1. Create the database tables with: `migrations/migrations.sql`.
2. Fix configs: `private/config.php` + `private/mysql.php`.
2. Populate database with API data with: `php private/sync.php`.
3. Run `public/index.php` in your browser to list the results.

#### TODO:

- find out more info about business logic, e.g. is order of images, properties important; field lengths in the API data
- images are not stored in the db (many-to-many???)
- no logging
- not enough error checking, esp. database operations
- classes need refactoring (there's a lot of code duplication)
- more consistent naming convention needed
- tidier includes
- forms need to save
- forms needs validation
- read-only forms are not read only
- custom parameters for the sync script (page size, sync only selected records)
- pagination on the search page (currently hardcoded)
- a lot more testing

