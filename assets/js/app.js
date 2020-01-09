const $ = require('jquery');
require('bootstrap');
const Popper = require('popper.js');

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');


require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(function(){
    $('.spoiler-text').hide();
    $('.spoiler-toggle').click(function(){
        $(this).next().toggle();
    }); // end spoiler-toggle
}); // end document ready

/**
\u0040fortawesome\/fontawesome\u002Dfree
bootstrap
fontawesome
jquery
popper.js
**/