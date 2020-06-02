import FlvJs from 'flv.js'
import { library, icon } from '@fortawesome/fontawesome-svg-core'

import '../css/tailwind.css'

import { faPlay } from '@fortawesome/free-solid-svg-icons'
library.add(faPlay)

document.getElementById('buttonIcon').innerHTML = icon({
  prefix: 'fas',
  iconName: 'play',
}).html

document.getElementById('playButton').addEventListener('click', () => {
  document.getElementById('buttonWrapper').remove()
  if (FlvJs.isSupported()) {
    const playerEl = document.createElement('video')
    playerEl.autoplay = true
    playerEl.controls = true
    playerEl.classList.add('w-screen')
    playerEl.classList.add('h-screen')
    document.getElementsByTagName('body')[0].appendChild(playerEl)


    const player = FlvJs.createPlayer({
      type: 'flv',
      isLive: true,
      url: stream_url,
    })
    player.attachMediaElement(playerEl)
    player.load()
    player.play()
    setInterval(() => {
      player.play()
    }, 1000)
  }
})
