#!/bin/sh
docker-compose up & python3 server.py & node ../coffeecall/server.js

