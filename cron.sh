#!/bin/bash

PROJECT_PATH="$HOME/repos/CrazyBolao"

COMMAND="$1"

if [ -z "$COMMAND" ]; then
    echo "No command provided."
    exit 1
fi

cd $PROJECT_PATH || exit 1

./vendor/laravel/sail/bin/sail artisan "$COMMAND"

exit 0