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

The official installation method is using [Docker](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/). Please install both tools according to their documentation.

If you want to make RTMPie available under a publicly accessible domain (e.g. demo.rtmpie.de), make sure to set up the necessary DNS settings before continuing.

When Docker is installed, proceed with installing RTMPie:
```bash
# Clone the repository
git clone https://github.com/ngrie/rtmpie.git

# Change into the directory
cd rtmpie

# Run the setup script and answer the questions
bash setup.sh

# Start the containers
docker compose up -d
```

The webinteface will be available after a few seconds and you can login using the default credentials `admin / admin`.

#### Stream Example

```bash
ffmpeg -re -i 'https://meclistv-live.ercdn.net/meclistv/meclistv_720p.m3u8' \
	-c:v libx264 -preset veryfast -b:v 1M -c:a aac -b:a 128k -f flv \
	'rtmp://127.0.0.1/live/test?key=5c24303c30494b198e6519ccde445758'
```

## Credits

RTMPie was built using the following projects:

- [nginx-http-flv-module](https://github.com/winshining/nginx-http-flv-module) (thanks to [arut](https://github.com/arut) for creating the original module and [winshining](https://github.com/winshining) for maintaining the further developed fork)
- [Symfony](https://symfony.com) and [API Platform](https://api-platform.com)
- [Vue.js](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com) and [Tailwind UI](https://tailwindui.com)
