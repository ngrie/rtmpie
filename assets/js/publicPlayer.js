import Plyr from 'plyr'
import Hls from 'hls.js'
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

    const playerEl = document.createElement('video')
    playerEl.autoplay = true
    playerEl.controls = true
    document.getElementsByTagName('body')[0].appendChild(playerEl)

    const plyr = new Plyr(playerEl, { controls: ['play-large', 'play', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'] });

    if (!Hls.isSupported()) {
        playerEl.src = stream_url;
    } else {
        const hls = new Hls();
        hls.loadSource(stream_url);
        hls.attachMedia(playerEl);
        window.hls = hls;
    }

    const plyrWrapper = document.getElementsByClassName('plyr')[0]
    plyrWrapper.classList.add('w-screen')
    plyrWrapper.classList.add('h-screen')

    plyr.muted = true
    setTimeout(() => {
        plyr.play()
    }, 500)
})
