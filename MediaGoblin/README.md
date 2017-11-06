## Description

Dockerizing [MediaGoblin](http://mediagoblin.org/) for easy trial.

Only recommended for trying out MediaGoblin locally. If one wanted deploy this docker image to a live site, the maintainer would strongly advise against it.

### This project is not actively worked on. If you try it, find it broken, and would like it to function again; please create, or comment on, an issue stating so.

## Usage

** AUTOMATED BUILD IMAGE DOES NOT WORK **
** OBTAIN SOURCE CODE AND SEE GITHUB NOTES **

    sudo docker run -it --name="mediagoblin" -p 6543:6543 vky0/mediagoblin:latest

**NOTE**: If the running container is stopped, there will be no continuation of the previous session when starting a new container. It will be a completely fresh slate, including having to create a user again.

## Github Notes

Running `./build.sh` from within this repo's directory will build the Docker image, and `./run.sh` will run the image. The resulting container is run interactively. The MediaGoblin instance should be accessible from http://localhost:6543. A user with the username `tests` and the password `tests` is created when the container starts.

## TODO

* Setup Postgres as a separate linked container.
* Volume mount configuration file?
* Volume mount data directory
* Setup additional plugins
    * Figure out how to get audio plugin working again
* Use [Docker Compose](https://docs.docker.com/compose/) to start up Postgres, MediaGoblin and any additional containers.
