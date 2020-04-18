const config = (key) => {
  return key ? rtmpie_config[key] : rtmpie_config
}

const getRtmpPrefix = () => `rtmp://${config('host')}/live/`

export {
  config,
  getRtmpPrefix,
}
