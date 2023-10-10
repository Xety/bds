import './bootstrap';
import Dismiss from './libs/dismiss.js'
import flatpickr from "flatpickr";
import { French } from "flatpickr/dist/l10n/fr.js";
import print from 'print-js';


// Set the datetime picker locale to french
flatpickr.localize(French);

export default {
    Dismiss
}

 // Scroll to Top
let buttonBackToTop = document.getElementById('btn-back-to-top');
let drawer = document.getElementsByClassName('drawer-content')[0];
// When the user clicks on the button, scroll to the top of the document
buttonBackToTop.addEventListener('click', function() {
    drawer.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

 // When the user scrolls down 60px from the top of the document, show the button
 drawer.onscroll = function () {
    if (drawer.scrollTop > 60) {
        buttonBackToTop.style.display = 'block';
    } else {
        buttonBackToTop.style.display = 'none';
    }
};
