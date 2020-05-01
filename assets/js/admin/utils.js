const config = (key) => {
  return key ? rtmpie_config[key] : rtmpie_config
}

const getRtmpPrefix = () => `rtmp://${config('host')}/live`

const generateErrorMessageFromResponse = (message, response) => {
  if (!response || !response.status) {
    return message
  }

  if (response.status === 401) {
    return 'Authentication expired, please reload the page to re-login and try again.'
  }

  return `${message} (Error code ${response.status})`
}

export {
  config,
  getRtmpPrefix,
  generateErrorMessageFromResponse,
}
