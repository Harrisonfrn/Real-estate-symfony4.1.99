/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import $ from 'jquery'
import '../css/app.css'
import 'select2'
import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'
import Places from 'places.js'
import Map from './modules/map'

Map.init()

const inputAddress = document.querySelector('#property_address')
if (inputAddress !== null) {
  const place = Places({
    container: inputAddress
  })
  place.on('change', e => {
    document.querySelector('#property_city').value = e.suggestion.city
    document.querySelector('#property_zip_code').value = e.suggestion.postcode
    document.querySelector('#property_lat').value = e.suggestion.latlng.lat
    document.querySelector('#property_lng').value = e.suggestion.latlng.lng
  })
}

const searchAddress = document.querySelector('#search_address')
if (searchAddress !== null) {
  const place = Places({
    container: searchAddress
  })
  place.on('change', e => {
    document.querySelector('#lat').value = e.suggestion.latlng.lat
    document.querySelector('#lng').value = e.suggestion.latlng.lng
  })
}

const fetch = require('node-fetch')

$('[data-slider]').slick({
  dots: true,
  infinite: true,
  speed: 500,
  fade: true
})

$('select').select2()

const $contactButton = $('#contactButton')
$contactButton.click(e => {
  e.preventDefault()
  $('#contactForm').slideDown()
  $contactButton.slideUp()
})

// Suppression des éléments
document.querySelectorAll('[data-delete]').forEach(a => {
  a.addEventListener('click', e => {
    e.preventDefault()
    fetch(a.getAttribute('href'), {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _token: a.dataset.token })
    }).then(response => response.json())
      .then(data => {
        if (data.success) {
          a.parentNode.parentNode.removeChild(a.parentNode)
        } else {
          alert(data.error)
        }
      })
      .catch(e => alert(e))
  })
})

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js')
