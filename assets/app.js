/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';



const $ = require('jquery');
global.$ = global.jQuery = $;
require("bootstrap");

var $pays = $('#registration_form_origin');
$pays.on("change", (evt) => {
    // $(".cible").removeClass('apparait');
    
    // if ($pays.val() == 0) {
    //     $(".cible").addClass('apparait');
    //     $pays.children().first().val(undefined);
    // } else {
    //     $pays.children().first().val("0");
    // };

    var $form = $(this).closest('form');
    console.log($form);
    console.log("ok");
    // Simulate form data, but only include the selected pays value.
    var data = {};
    data[$pays.attr('name')] = $pays.val();
    // Submit data via AJAX to the form's action path.
    $.ajax({
      url : $form.attr('action'),
      type: $form.attr('method'),
      data : data,
      complete: function(html) {
        // Replace current position field ...
        $('#registration_form_ville').replaceWith(
          // ... with the returned one from the AJAX response.
            $(html.responseText).find('#registration_form_ville'));
          console.log(html);
        ;
        // Position field now displays the appropriate positions.
      }
    });


    // console.log($pays.val(),typeof($pays.val()),parseInt($pays));
});

  

