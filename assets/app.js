import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//import bootstrap bundle
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// start the Stimulus application
import "./bootstrap";

//import noUiSlider bundle
import * as noUiSlider from "nouislider";
window.noUiSlider = noUiSlider;
import "nouislider/dist/nouislider.css";

//enable boostrap Popover
const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);
