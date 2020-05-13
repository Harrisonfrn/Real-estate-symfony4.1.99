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

// Supression des éléments(img)
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
          alertMessage(data.error)
        }
      })
      .catch(e => alertMessage(e))
  })
})

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js')
