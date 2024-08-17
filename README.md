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
# Create a directory for the installation and change the working directory
mkdir /opt/rtmpie
cd /opt/rtmpie

# Download the small installer script
wget -q -O setup.sh https://github.com/keyiflerolsun/rtmpie/blob/main/setup.sh?raw=True

# Make the script executable
chmod +x setup.sh

# Run the installer and answer the questions
bash setup.sh

# Start the containers
docker compose up -d
```

The webinteface will be available after a few seconds and you can login using the default credentials `admin / admin`.

## Usage

### Stream a Video

To stream a video to your RTMP server, use the following command. This example uses `ffmpeg` to take an input stream and transcode it to RTMP format, then sends it to your RTMP server at the specified address.

```bash
ffmpeg -re -i 'https://meclistv-live.ercdn.net/meclistv/meclistv_720p.m3u8' \
	-c:v libx264 -preset medium -b:v 1M -s 1280x720 -c:a aac -b:a 128k -f flv \
	'rtmp://127.0.0.1/live/test?key=5c24303c30494b198e6519ccde445758'
```

- Replace the input URL with your video source,
- the RTMP URL with your stream server address,
- and the key parameter with your stream secret key.

### Watch the Stream

You can either watch the stream by clicking on the preview image on the admin interface.
If you want to embed the stream anywhere else, you can access the `.m3u8` file via the following URL.

```bash
http://127.0.0.1:8080/live/{slug}/index.m3u8
```

- **{slug} has to be replaced by the stream name**


## Credits

RTMPie was built using the following projects:

- [nginx-http-flv-module](https://github.com/winshining/nginx-http-flv-module) (thanks to [arut](https://github.com/arut) for creating the original module and [winshining](https://github.com/winshining) for maintaining the further developed fork)
- [Symfony](https://symfony.com) and [API Platform](https://api-platform.com)
- [Vue.js](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com) and [Tailwind UI](https://tailwindui.com)
