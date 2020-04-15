const config = (key) => {
  return key ? rtmpie_config[key] : rtmpie_config
}

export {
  config,
}
