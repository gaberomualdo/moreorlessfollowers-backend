# moreorlessfollowers-backend

More or less followers game backend and API.

### File structure:

- `get-random-account.php` --> main API route used by the frontend
- `import-data.php` --> protected route used to import new accounts data for the site
- `auth-token.php` --> includes the correct auth token (`$auth_token`) used in the `import-data` route
- `accounts.json` --> all the account data stored in a JSON file
- `images/` --> cached and downsized images for the site, used in the database
- `get-data-last-updated.php` --> protected route used to provide the time that the data was last updated
- `remove-old-imgs.php` --> protected route used to delete old unused cached images
- `download-img.php` --> protected route used to download and cache images from public URLs (namely images from Instagram)
