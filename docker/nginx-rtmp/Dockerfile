FROM ngrie/nginx-rtmp:latest

RUN apk --no-cache add ffmpeg

RUN mkdir -p /var/thumbnails /tmp/thumbnail_recordings && \
    chown -R nginx:nginx /var/thumbnails && \
    chmod -R 770 /var/thumbnails && \
    chown -R nginx:nginx /tmp/thumbnail_recordings && \
    chmod -R 770 /tmp/thumbnail_recordings

COPY docker/nginx-rtmp/nginx.conf /etc/nginx/nginx.conf

COPY docker/nginx-rtmp/create-thumbnail.sh /opt/create-thumbnail.sh
RUN chmod +x /opt/create-thumbnail.sh
