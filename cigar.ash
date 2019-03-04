#!/bin/bash

function main {
    php ./app multi http-server &
    local pid=$!
    sleep 5
    ./vendor/bin/cigar
    local ec=$?
    kill $pid
    exit $ec
}

main
