/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import $ from 'jquery'
import '../css/app.css'
import 'select2'

$('select').select2()

const $contactButton = $('#contactButton')
$contactButton.click(e => {
  e.preventDefault()
  $('#contactForm').slideDown()
  $contactButton.slideUp()
})

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js')
