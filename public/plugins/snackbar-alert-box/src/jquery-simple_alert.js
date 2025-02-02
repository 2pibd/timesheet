
    function simpleAlert(props = {}) {
        if (!window.jQuery) {  
            alert("Please Add Jquery Before this script")
            return;
        }
        if ($('.simple_alert_div').length != 0) {
            $(".simple_alert_div").remove();
        }
        // $(".simple_alert_div").hide('fast', 'swing', function () {
        //     $(".simple_alert_div").remove();
        // });
        let bg_color = props.bg_color
        let text = props.text
        let text_color = props.text_color
        let orientation = props.orientation
        let after_alert = props.after_alert
        $("body").append(`<div class="simple_alert_div" class="text-center py-2 text-white px-4 mx-auto">
        <span id="simple_alert_message"></span>
        </div>`)
        if (text_color) {
            $(".simple_alert_div").css('color', text_color)
        }
        if (!text) {
            text = "Hello World this is a simple alert with jquery"
        }
        if (bg_color) {
            $(".simple_alert_div").css('background-color', bg_color)
        }

        if (orientation) {
            if (orientation == "bl") {
                $(".simple_alert_div").css('bottom', '10px')
                $(".simple_alert_div").css('left', '10px')
            }
            if (orientation == "tl") {
                $(".simple_alert_div").css('top', '10px')
                $(".simple_alert_div").css('left', '10px')
            }
            if (orientation == "br") {
                $(".simple_alert_div").css('bottom', '10px')
                $(".simple_alert_div").css('right', '10px')
            }
            if (orientation == "tr") {
                $(".simple_alert_div").css('top', '10px')
                $(".simple_alert_div").css('right', '10px')
            }
        } else {
            $(".simple_alert_div").css('bottom', '10px')
            $(".simple_alert_div").css('right', '10px')
        }

        $("#simple_alert_message").html(`${text} <b class="snackbar_dismiss">Okay</b>`)
        $(".snackbar_dismiss").click(() => {
            $(".simple_alert_div").hide('fast', 'swing', function () {
                if (after_alert) {
                    after_alert()
                }
                $(".simple_alert_div").remove();
            });
        })

    }