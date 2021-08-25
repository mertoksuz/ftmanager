#!/usr/bin/env bash
docker-compose -f docker-compose.yml up -d --build
docker-compose -f docker-compose.yml exec -T php composer install -n