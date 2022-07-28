/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)



//node_module -> je ne mets pas le ./
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js';
import './css/sticky-nav.css';

import 'bootstrap/dist/js/bootstrap.js';
import 'jquery/dist/jquery.min.js';

// ES6 Modules or TypeScript
import Swal from 'sweetalert2/dist/sweetalert2.js'

// CommonJS
global.Swal = require('sweetalert2')


// start the Stimulus application
import './bootstrap';
