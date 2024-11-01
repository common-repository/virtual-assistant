var VA_CLASS = VA_CLASS || {};

(function(VA_CLASS, $) {
    'use strict';

    VA_CLASS = VA_CLASS || {};
    $.extend(VA_CLASS, {

        SIRI: {
            init: function() {
                this.build(this);
            },
            build: function(){
                if (annyang && typeof va_commands != 'undefined') {

                    $('.wpva-button-micro').addClass('active');
                    
                    if(VA_SETTINGS.SPEAK_INTRO != '' && typeof responsiveVoice != 'undefined') {
                        setTimeout(responsiveVoice.speak( VA_SETTINGS.SPEAK_INTRO, VA_SETTINGS.VA_VOICE ), 1000);
                    }
                    annyang.setLanguage(VA_SETTINGS.USER_LANG);
                    // Add our commands to annyang
                    annyang.addCommands(va_commands);

                    annyang.addCallback('result',function(whatWasHeard) {
                        document.getElementById("wpva_text_command").value = whatWasHeard[0];
                        // console.log('RR:' + whatWasHeard[0]);
                        // console.log('RR:VA_SETTINGS:' + VA_SETTINGS.USER_LANG);
                        // console.log('RR:va_commands:' + va_commands);
                    });

                    annyang.start();

                  
                }
                
                if (!annyang) {
                    $('#wpva_text_command').val("Your browser doesn't support SpeechRecognition!");
                }
            },
        }
    });
}).apply(this, [window.VA_CLASS, window.jQuery]);

(function($) {
    'use strict';
    
    $(document).ready(function() {
        if (typeof VA_CLASS.SIRI !== 'undefined') {
            VA_CLASS.SIRI.init();
            // SpeechKITT.startRecognition();
        }
        $('.bb_va_button_popup').on('click', function(){
            $(this).toggleClass('active');
            $('.bb_va_popup').toggleClass('active');
        })

    });
}(window.jQuery));