set dotenv-load := true

set shell := ["bash", "-c"]

all:
    just grumphp

_docker version command:
    docker run --rm -v $(pwd):/app --env-file .env -w /app kanti/buildy:{{ version }} {{ command }}

_clean:
    just _docker "8.0" "rm -rf vendor/ composer.lock"

install version="8.0":
    just _clean
    just _docker {{ version }} "composer install"

grumphp version="8.0":
    just install {{ version }}
    just _docker {{ version }} "vendor/bin/grumphp run"

fix:
    just install "8.0"
    just _docker "8.0" "/app/vendor/bin/php-cs-fixer --config=.php-cs-fixer.dist.php --using-cache=no --verbose fix"

#test version="8.0":
#    just install {{ version }}
#    just _docker {{ version }} "composer test"
