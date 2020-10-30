Test Task
=

Setup env:
```shell script
docker-compose up -d --build
```

Setup app:

Notes:
* prefix `#` mean that command should be run inside container
* `# {command}` can be replaced by `docker exec -it app {command}`

```shell script
docker exec -it app bash
# composer install
```
