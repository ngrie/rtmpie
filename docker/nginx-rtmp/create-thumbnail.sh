#!/bin/sh
sleep 5 && ffmpeg -i $1 -vcodec png -vframes 1 -an -f rawvideo -s 320x240 -ss 00:00:00 -y /var/thumbnails/$2.png
