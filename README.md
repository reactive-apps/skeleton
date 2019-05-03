# Reactive App Skeleton

[![Build Status](https://travis-ci.com/reactive-apps/skeleton.svg?branch=master)](https://travis-ci.com/reactive-apps/skeleton)
[![Latest Stable Version](https://poser.pugx.org/reactive-apps/skeleton/v/stable.png)](https://packagist.org/packages/reactive-apps/skeleton)
[![Total Downloads](https://poser.pugx.org/reactive-apps/skeleton/downloads.png)](https://packagist.org/packages/reactive-apps/skeleton/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/reactive-apps/skeleton/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/reactive-apps/skeleton/?branch=master)
[![License](https://poser.pugx.org/reactive-apps/skeleton/license.png)](https://packagist.org/packages/reactive-apps/skeleton)
[![PHP 7 ready](http://php7ready.timesplinter.ch/reactive-apps/skeleton/badge.svg)](https://travis-ci.com/reactive-apps/skeleton)


# Create a new project based on this skeleton

The following command will create a new project based on this skeleton in the `your-project-name` directory: 
```
composer create reactive-apps/skeleton your-project-name
```

# Before you get started

Copy the `.env.example` to `.env` and adjust where needed. Make sure to match the post of `REACT_HTTP_SOCKET_ADDRESS` 
with the post in `cigar.json`.

# Usage

This skeleton comes with a set of `make` commands to ease the QA and development. Running `make` will do a full QA run 
including `linting`, `code style checks`, `unit tests`, and `smoke testing`.

This is a fully command line based tool with it's own `HTTP` server build in. Running `./app` will list the available 
commands. For example `./app http-server` will start. It is also possible to run multiple commands at once, for example 
the following runs the `HTTP` server, metrics collection, and internal cron (the latter two aren't included by default): 
`./app multi metrics cron http-server`.

## Docker Compose

Alternatively there is `make dev` that will boot up a full dev environment using `docker-compose` that includes:

* Running this app with the HTTP server available on `localhost:54321` (host might differ on non-Linux platforms)
* [`Grafana`](https://grafana.com/grafana) on `localhost:3000` with user/password `admin`/`admin` for application, system and services metrics
* [`Graphite`](https://graphiteapp.org/) / [`InfluxDB`](https://www.influxdata.com/time-series-platform/influxdb/) for metrics storage and feeding them to [`Grafana`](https://grafana.com/grafana)
* [`Telegraf`](https://www.influxdata.com/time-series-platform/telegraf/) gathering metrics pushing them to [`Graphite`](https://graphiteapp.org/) / [`InfluxDB`](https://www.influxdata.com/time-series-platform/influxdb/)
* [`RabbitMQ`](https://www.rabbitmq.com/) for message consumer in your app but also used for getting metrics from the app to  [`Telegraf`](https://www.influxdata.com/time-series-platform/telegraf/)

# Logging

The app is by default shipped with [`Monolog`](https://github.com/Seldaek/monolog) for logging and `STDOUT` logging for 
colour logging to the command line. Any additional handlers and processors can be configured in the `etc/config/logger.php` 
configuration file. The `http-server.php` next to it also shows off how it can be used together with DI.

# HTTP Server

The `HTTP` server command looks at `composer.json` to find configured controllers and sets those up for when requests 
come in. A controller can be both static and instanced. With the latter useful for when you need to do more then the 
basics where no injected dependencies are required. The configuration is done through annotations for the allowed 
`HTTP` method and route. The HTTP server documentation can be found [here](https://github.com/reactive-apps/command-http-server).

# License

The MIT License (MIT)

Copyright (c) 2019 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
