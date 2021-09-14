# Laravel-SQlite-Docker-Authorization-CRUD
A sample project for Authentication and Authorization of a sample CRUD operations developed with Docker, Laravel, REST APIs, and SQlite.
## Usage

- **nginx** - `:80`
- **php** - `:9000`

Three additional containers are included that handle Composer, NPM, and Artisan commands *without* having to have these platforms installed on your local computer. Use the following command examples from your project root, modifying them to fit your particular use case.

- `docker-compose run --rm composer update`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan migrate`

## Permissions Issues

If you encounter any issues with filesystem permissions while visiting your application or running a container command, try completing the following steps:

- Bring any container(s) down with `docker-compose down`
- Copy the `.env.example` file in the root of this repo to `.env`
- Modify the values in the `.env` file to match the user/group that the `src` directory is owned by on the host system
- Re-build the containers by running `docker-compose build --no-cache`

Then, either bring back up your container network or re-run the command you were trying before, and see if that fixes it.

## API Documentaions
All APIs have a documentation. 
https://documenter.getpostman.com/view/15724966/U16nL4ZW#aebcb5b7-399a-4281-9b4e-6dc7230ad774



## Testing
Inside docker container go the src folder and run the following command for testing.
```bash
vendor/bin/phpunit
```

## View Activity Logs
All activites logs have been created in the following folder:
```bash
Storage->Logs->
```

## Using BrowserSync with Laravel Mix

If you want to enable the hot-reloading that comes with Laravel Mix's BrowserSync option, you'll have to follow a few small steps. First, ensure that you're using the updated `docker-compose.yml` with the `:3000` and `:3001` ports open on the npm service. Then, add the following to the end of your Laravel project's `webpack.mix.js` file:

```javascript
.browserSync({
    proxy: 'nginx',
    open: false,
    port: 3000,
});
```

From your terminal window at the project root, run the following command to start watching for changes with the npm container and its mapped ports:

```bash
docker-compose run --rm --service-ports npm run watch
```

That should keep a small info pane open in your terminal (which you can exit with Ctrl + C). Visiting [localhost:8000](http://localhost:8000) in your browser should then load up your Laravel application with BrowserSync enabled and hot-reloading active.

