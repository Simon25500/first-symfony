/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

import select2 from 'select2';
import animeForm from "./contactform";

const select = $('select');

if (select) {
    select.select2();
}

const button = document.querySelector('#button');

if (button) {
    button.addEventListener('click', event => {
        event.preventDefault();
        animeForm();
    });
}


