#!/bin/bash

PROJECT_PATH="$HOME/repos/CrazyBolao"
COMMAND="$1"
LOG_FILE="$PROJECT_PATH/storage/logs/cron-error.log"


if [ -z "$COMMAND" ]; then
    echo "$(date '+%Y-%m-%d %H:%M:%S') - No command provided." >> "$LOG_FILE"
    exit 1
fi

cd "$PROJECT_PATH" || {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - Failed to access project path." >> "$LOG_FILE"
    exit 1
}

docker exec -t crazybolao-crazydot-app-1 php artisan "$COMMAND" > /dev/null 2>> "$LOG_FILE"

exit 0

