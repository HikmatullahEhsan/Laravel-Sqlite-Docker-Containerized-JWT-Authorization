# docker-compose-laravel
A pretty simplified Docker Compose workflow that sets up a LEMP network of containers for local Laravel development. You can view the full article that inspired this repo [here](https://dev.to/aschmelyun/the-beauty-of-docker-for-local-laravel-development-13c0).

[![GitNFT](https://img.shields.io/badge/%F0%9F%94%AE-Open%20in%20GitNFT-darkviolet?style=flat)](https://gitnft.quine.sh/app/commits/list/repo/docker-compose-laravel)

## Usage

To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on your system, and then clone this repository.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d --build site`.

After that completes, follow the steps from the [src/README.md](src/README.md) file to get your Laravel project added in (or create a new blank one).

Bringing up the Docker Compose network with `site` instead of just using `up`, ensures that only our site's containers are brought up at the start, instead of all of the command containers as well. The following are built for our web server, with their exposed ports detailed:

- **nginx** - `:80`
- **mysql** - `:3306`
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

That should keep a small info pane open in your terminal (which you can exit with Ctrl + C). Visiting [localhost:3000](http://localhost:3000) in your browser should then load up your Laravel application with BrowserSync enabled and hot-reloading active.

