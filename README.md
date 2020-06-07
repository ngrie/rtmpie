# RTMPie

RTMPie is a management web interface for the RTMP NGINX module.

<p align="center">
  <img src="https://img.rtmpie.de/screen.png" alt="RTMPie screenshot">
</p>

### Features

- Get information about streams (live/offline, viewer count) in realtime
- Simple user management
- Stream key management to prevent unauthorized clients from streaming to the server
- Kick the current publisher from a stream
- Integrated stream player
- Stream recording (coming soon)
- Restrict stream playback to authenticated users (coming soon)

## Installation

The official installation method is using [Docker](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/).

A detailed guide will be coming soon. For now you can refer to [this compose file](docker/docker-compose.prod.yaml) to create a setup yourself.

## Credits

RTMPie was built using the following projects:

- [nginx-http-flv-module](https://github.com/winshining/nginx-http-flv-module) (thanks to [arut](https://github.com/arut) for creating the original module and [winshining](https://github.com/winshining) for maintaining the further developed fork)
- [Symfony](https://symfony.com) and [API Platform](https://api-platform.com)
- [Vue.js](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com) and [Tailwind UI](https://tailwindui.com)
