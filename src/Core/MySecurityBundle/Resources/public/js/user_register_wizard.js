var FormWizard = function () {


    return {
        //main function to initiate the module
        init: function (formId) {
            if (!jQuery().bootstrapWizard) {
                return;
            }


            var form = $('#'+formId);
            var wizard = $('#'+formId+"_wizard");

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                focusInvalid: false // do not focus the last invalid input
            });

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', wizard).text('Paso ' + (index + 1) + ' de ' + total);
                // set done steps
                jQuery('li', wizard).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    wizard.find('.button-previous').hide();
                } else {
                    wizard.find('.button-previous').show();
                }

                if (current >= total) {
                    wizard.find('.button-next').hide();
                    wizard.find('.button-submit').show();
                } else {
                    wizard.find('.button-next').show();
                    wizard.find('.button-submit').hide();
                }
                App.scrollTop();
            }

            // default form wizard
            wizard.bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    wizard.find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            wizard.find('.button-previous').hide();
            $('.button-submit',wizard).click(function () {
                form.submit();
            }).hide();
        }

    };

}();
