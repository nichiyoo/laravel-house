import embla from 'embla-carousel'

const slides = document.querySelector('#slides')
slides && embla(slides, {
  loop: true,
  align: 'start',
  containScroll: true,
})

const chips = document.querySelector('#chips')
chips && embla(chips, {
  loop: true,
  align: 'start',
  containScroll: true,
})