<script>
    function fetchCities(event){
        exp_country_id = $(event).val();
        $('#exp_city').empty();
        $('#exp_city').append('<option>Loading...</option>');
        disableItem($(".search_exp_btn"), true)
        disableItem($('#exp_city'), true);
        $.ajax({
            type:"GET",
            url:"{{url('api/getcities')}}"+"/"+exp_country_id,
            headers:{token:1200},
            dataType:"json",
            success: function(res){
                $('#exp_city').empty();
                disableItem($('#exp_city'), false);
                disableItem($(".search_exp_btn"), false)
                if (res.status == 200 ){

                    $.each(res.data, function(key,value)
                    {
                        $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+ucFirst(value.name.toLowerCase())+'</option>');
                    });

                }
            },
            error: function (response, status, error) {
                $('#exp_city').empty();
                $('#exp_city').append('<option>Select city</option>');
                if(response.status == 500){
                    alertui.notify('error', 'An Error Occurred. Please try again.')
                }
                else{
                    alertui.notify('error', response.responseJSON.data)
                }
            }
        });
    }
</script>
<script>

    var participants_form_array  = [];
    var per_booking_form_object  = {};
    var participants_count  = 0;
    var selected_vxcf  = 0;
    var selected_signature = "";
    var selected_type = "";
    var seats_available = 0;
    var session_start, session_end;
    Date.prototype.getDayOfWeek = function(){
        return ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][ this.getDay() ];
    };

    Date.prototype.isSameDateAs = function(pDate) {
        return (
            this.getFullYear() === pDate.getFullYear() &&
            this.getMonth() === pDate.getMonth() &&
            this.getDate() === pDate.getDate()
        );
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    var validateEmail = function(email) {
        const expression = /(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

        return expression.test(String(email).toLowerCase())
    }

    $(document).ready(function () {

        $(".form2").hide();
        $(".booking_actions_container").hide();
        $(".other_forms").hide();
        $(".form1").show();
        $(".nextform").show();
        $(".sendformdiv").hide();

        //Load experience availability
        $.ajax({
            url: "{!! url('get_experience_availabilities', ['id' => $product->data->item_code]) !!}"
        })
            .done(function(res) {
                availabilities = res.data;
                var dates = [];
                $.each(res.data, function (index, item) {
                    dates.push(item.start_time)
                });
                $(".loader").addClass('off')
                //FlatPicker Setup
                var options = {
                    enable: dates,
                    altInput: true,
                    altFormat: "F j, Y",
                    enableTime: false,
                    inline: true,
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr, instance) {
                        $(".availability_details").removeClass('availability_details_show').addClass('availability_details_show_reverse');
                        $.each(availabilities, function (index, item) {
                            if(new Date(dateStr).isSameDateAs(new Date(item.start_time))){
                                buildPriceOptions(item.type_options)
                                seats_available = item.seats_available;
                                session_start = moment(item.start_time).format('lll');
                                session_end = moment(item.end_time).format('lll');
                                $(".availability_details .seats_available").html(item.seats_available)
                                $(".availability_details .start_time").html(moment(item.start_time).format('lll'))
                                $(".availability_details .end_time").html(moment(item.end_time).format('lll'))

                                $(".experience_modal_details .details .start_time").html(moment(item.start_time).format('lll'))
                                $(".experience_modal_details .details .end_time").html(moment(item.end_time).format('lll'))
                            }
                        });
                        setTimeout(function () {
                            $(".availability_details").removeClass('availability_details_show_reverse').addClass('availability_details_show');
                        }, 300)

                    }
                }

                flatpickr("#datepicker", options);
            })
            .fail(function() {
                $(".loader").addClass('off')
            })


        $("#bookexp").click(function(e){
            getParticipantsForms()
            perBookingForm()
            disableItem($("#bookexp"), true)
            $(".redeem_process_indicator").removeClass('off');
            // console.log(validateParticipantsForms())
            if( !validateParticipantsForms() ){
                alertui.alert("<h4 style='color:red'>Validation Error!</h4>","Kindly complete the booking forms.");
                $(".redeem_process_indicator").addClass('off');
                disableItem($("#bookexp"), false)
                return false;
            }
            var formData = {
                quantity : participants_count,
                first_name : $("input[name='customer_firstname']").val(),
                last_name : $("input[name='customer_lastname']").val(),
                email : $("input[name='customer_email']").val(),
                phone_no : $("input[name='customer_phone_no']").val(),
                participant_form : participants_form_array,
                per_booking_form : per_booking_form_object,
                signature : selected_signature,
                type : selected_type,
                price : selected_vxcf,
                session_start : session_start,
                session_end : session_end,
                name : "{!! $product->data->name !!}"+ " - "+selected_type,
            }


            $.post("{{url('api/checkout_experience')}}",formData )
                .done(function (res) {
                    $(".redeem_process_indicator").addClass('off');
                    disableItem($("#bookexp"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error','Failed to complete booking');
                        return false;
                    }
                    if (res.status == '400') {
                        alertui.alert("<h4 style='color:red'>Error</h4>", res.message);
                        return false;
                    }
                    if (res.status == 'fail') {
                        alertui.alert("<h4 style='color:blue'>Booking Error</h4>",' Sorry! Booking failed.');
                        return false;
                    }

                    if (res.status == '200') {
                        updateAccount(res.account)
                        $('#modal').modal('hide');
                        alertui.notify('success', res.message);
                        window.location.replace("{{url('ordercomplete')}}/"+res.order_id)
                    }
                })
                .fail(function (response, status, error) {
                    // handle error
                    $(".redeem_process_indicator").addClass('off');
                    disableItem($("#bookexp"), false)
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                    }
                    else{
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                    }
                })

        });

    });


    //Start booking
    $(".start_booking").click( function () {
        $(".experience_modal_details .image").css('background-image', "url("+getCookie('single_experience_image')+")")
        // $(".experience_modal_details .details h4").html(getCookie('single_experience_name').replace('+', ' '))
        $("#booking_modal").modal('show')
    });

    //Caretaking after modal close
    $('#booking_modal').on('hidden.bs.modal', function (e) {
        $(".form2", ".booking_actions_container").hide();
        $(".form1").show();
        $(".nextform").show();
        $(".sendformdiv").hide();
        $(".booking_actions_container").hide();
    })

    function nextForm(e) {
        participants_count = $(event.target).parent().find("input").val();
        selected_vxcf = $(event.target).parent().data('price');
        selected_signature = $(event.target).parent().data('signature');
        selected_type = $(event.target).parent().data('type');

        if(participants_count > seats_available){
            alertui.alert("<h4 style='color:red'>Booking Error!</h4>",seats_available+ " Maximum seats available.");
            return false;
        }
        disableItem($(".nextform"), true);
        $(".forms_container").empty()
        $(".form1").hide();
        $(".form2").show();
        $(".booking_actions_container").hide();
        $(".forms_container").hide();
        $(".sendformdiv").hide();
        $(".other_forms").hide();
        $(".form2_loader").removeClass('off');

        $.ajax({
            url: "{!! url('get_experience_booking_form', ['id' => $product->data->item_code]) !!}"
        })
            .done(function(res) {
                    $(".form2_loader").addClass('off');
                    disableItem($(".nextform"), false);
                    $(".form1").hide();
                    $(".form2").show();
                    $(".forms_container").show();
                    $(".booking_actions_container").show();
                    $(".other_forms").show();
                    $(".nextform").hide();
                    $(".sendformdiv").show();
                    addForm(participants_count, res.data.data)
                }
            )
            .fail(function(res) {
                    $(".form2_loader").addClass('off')
                }
            )

    }

    $(".prevform").click(function (e) {
        $(".form2").hide();
        $(".booking_actions_container").hide();
        $(".form1").show();
        $(".nextform").show();
        disableItem($(".nextform"), false);
    })

    function getParticipantsForms() {
        var form_item = { };
        participants_form_array = [];
        var forms = $(".forms_container").find("form");
        $.each(forms, function (index, form) {
            $.each(form, function (index, item) {

                var label = $(item).data('label');
                form_item[label] = {
                    value: $(item).val(),
                    bp_guid: $(item).data('bp_guid'),
                    type: $(item).data('type'),
                };
            });
            participants_form_array.push(form_item);
        });

    }

    function perBookingForm() {
        var form_item = {};
        per_booking_form_object = {};
        var form = $("form.booking_form");
        $.each(form, function (index, item) {
            $.each(item, function (index, item2) {
                var label = $(item2).data('label');
                form_item[label] = {
                    value: $(item2).val(),
                    label: $(item2).data('label'),
                    type: $(item2).data('type'),
                };

                Object.assign(per_booking_form_object, form_item);
            });
        })
    }

    function buildPriceOptions(data) {
        var container = $(".price_options");

        container.empty();
        $.each(data, function (index, item) {
            var price_option ="<div style='width: 100%'>"
             price_option += "<div class='price_option_item' data-price='"+item.price_raw+"' data-type='"+item.type+"' data-signature='"+item.signature+"' style='width:25%;'>"
            price_option += "<div style='width:25%;'>"+item.type_label+"</div>";
            price_option += "<div style='width:25%;'>"+item.price_processed+ ' '+item.currency+"</div>";
            price_option += "<div style='width:25%;'><input type='number' min='1' value='1' class='form-control' placeholder='Qty' style='width: 100px;'></div>";
            price_option += "<button class='btn custom_button_color_2 nextform' onclick='nextForm()'>Select</button>";
            price_option += "</div>";
            price_option += "</div>";

            container.append(price_option);
            // container.append("<button class='btn custom_button_color_2 nextform' onclick='nextForm()'>Select</button>");
        });
    }

    function buildFormOptions(array_of_options) {
        var options = "";
        $.each(array_of_options, function (index, item) {
            options += "<option value='"+item+"'>" +item +"</option>"
        });
        return options;
    }

    function buildForm(object) {
        var input = "<form class='participant_form'>";

        $.each(object, function (index, item) {
            if (item.required_per_participant) {
                switch (item.input_type) {
                    case "date":
                        input += "<div class='col-sm-6'><span class='label label-danger off'>Required</span> <label>" + item.label + "</label>" + "<input data-label='" + item.label + "' name='" + item.label + "' data-bp_guid='" + item.bp_guid + "' data-type='" + item.input_type + "' type='date' class='form-control' required></div>";
                        break
                    case "text":
                        input += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<input data-label='" + item.label + "' name='" + item.label + "' data-bp_guid='" + item.bp_guid + "' data-type='" + item.input_type + "' type='text' class='form-control' required></div>";
                        break
                    case "select":
                        input += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<select  data-label='" + item.label + "' name='" + item.label + "' data-bp_guid='" + item.bp_guid + "' data-type='" + item.input_type + "' class='form-control' required>" + buildFormOptions(item.list_options) + "</select></div>";
                        break
                    case "number":
                        input += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<input  data-label='" + item.label + "' name='" + item.label + "' data-bp_guid='" + item.bp_guid + "' data-type='" + item.input_type + "' type='number' class='form-control' required></div>";
                        break
                }
            }
        });

        input +="</form>"
        return input;
    }

    function buildBookingForm(object) {
        var booking_form = "<form class='booking_form'>";
        $.each(object, function (index, item) {
            if(item.required_per_booking) {
                switch (item.input_type) {
                    case "date":
                        booking_form += "<div class='col-sm-6'><span class='label label-danger off'>Required</span> <label>" + item.label + "</label>" + "<input name='" + item.label + "' data-label='"+item.label+"' data-bp_guid='"+item.bp_guid+"' data-type='"+item.input_type+"' type='date' class='form-control' required></div>";
                        break
                    case "text":
                        booking_form += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<input name='" + item.label + "' data-label='"+item.label+"' data-bp_guid='"+item.bp_guid+"' data-type='"+item.input_type+"' type='text' class='form-control' required></div>";
                        break
                    case "select":
                        booking_form += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<select name='" + item.label + "'  data-label='"+item.label+"' data-bp_guid='"+item.bp_guid+"' data-type='"+item.input_type+"' class='form-control' required>"+ buildFormOptions(item.list_options) +"</select></div>";
                        break
                    case "number":
                        booking_form += "<div class='col-sm-6'><span class='label label-danger off'>Required</span><label>" + item.label + "</label>" + "<input name='" + item.label + "'  data-label='"+item.label+"' data-bp_guid='"+item.bp_guid+"' data-type='"+item.input_type+"' type='number' class='form-control' required></div>";
                        break
                }
            }
        })
        booking_form +="</form>"
        return booking_form;
    }

    function addForm(participants_count, res){

        //Add Participant form
        for (i = 1; i <= participants_count; i++) {
            $(".forms_container").append(generateForm(i, res))
        }

        //Add Booking form
        $(".per_booking_form").empty().append(buildBookingForm(res))
    }

    function generateForm(number, res) {
        var form = "";
        if(i == 1) {
            form += "<div class='panel panel-default'>";
            form += "<div class='panel-heading' role='tab' id='heading" + number + "'>";
            form += "<h5 class='panel-title'>";
            form += "<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse" + number + "' aria-controls='#collapse" + number + "'>";
            form += "Participant " + number + " (Required)</a>";
            form += "</h5>";
            form += "</div>";
            form += "<div id='collapse" + number + "' class='panel-collapse collapse in row' role='tabpanel' aria-labelledby='heading" + number + "'>";
            form += "<div class='panel-body col-sm-12'>";
            form += "<div class='row'>";
            form += buildForm(res);
            form += "</div>";
            form += "</div>";
            form += "</div>";
            form += "</div>";
            return form;
        }else{
            form += "<div class='panel panel-default'>";
            form += "<div class='panel-heading' role='tab' id='heading" + number + "'>";
            form += "<h4 class='panel-title'>";
            form += "<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse" + number + "' aria-controls='#collapse" + number + "'>";
            form += "Participant " + number + "</a>";
            form += "</h4>";
            form += "</div>";
            form += "<div id='collapse" + number + "' class='panel-collapse collapse row' role='tabpanel' aria-labelledby='heading" + number + "'>";
            form += "<div class='panel-body col-sm-12'>";
            form += "<div class='row'>";
            form += buildForm(res);
            form += "</div>";
            form += "</div>";
            form += "</div>";
            form += "</div>";
            return form;
        }
    }

    function validateParticipantsForms(){
        var forms = $(".forms_container").find("form");
        var booking_form = $("form.booking_form");
        var customer_details_form = $(".customer_details_form input");
        var error = true;

        $.each(booking_form[0], function (index, item) {

            var name = $(item).attr('name');
            if(isEmpty($(item).val()) == true){
                $(item).parent().find("span.label").removeClass('off')
                error = false;
                return false;
            }else{
                if(name != "Email") {
                    if (!$(item).parent().find("span.label").hasClass('off')) {
                        $(item).parent().find("span.label").addClass('off')
                    }
                    error = true;
                }else{
                    if(validateEmail($(item).val())){
                        if (!$(item).parent().find("span.label").hasClass('off')) {
                            $(item).parent().find("span.label").addClass('off')
                        }
                        error = true;
                    }else{
                        $(item).parent().find("span.label").removeClass('off');
                        error = false;
                        return false;
                    }
                }
                if(name == "Mobile") {
                    if($(item).val().length > 11 || $(item).val().length < 10) {
                        error = false;
                        return false;
                        $(item).parent().find("span.label").removeClass('off');
                    }else{
                        $(item).parent().find("span.label").addClass('off');
                        error = true;
                    }
                }

            }

        });

        if(error) {
            $.each(forms, function (index, form) {
                $.each(form, function (index, item) {

                    if (isEmpty($(item).val()) == true) {
                        $(item).parent().find("span.label").removeClass('off');
                        error = false;
                        return false;
                    } else {
                        if (!$(item).parent().find("span.label").hasClass('off')) {
                            $(item).parent().find("span.label").addClass('off')
                        }
                        error = true;
                    }

                });
            });
        }


        if(error) {
            $.each(customer_details_form, function (index, item) {
                if (isEmpty($(item).val()) == true) {
                    $(item).parent().find("span.label").removeClass('off');
                    error = false;
                    return false;
                } else {
                    if (!$(item).parent().find("span.label").hasClass('off')) {
                        $(item).parent().find("span.label").addClass('off')
                    }
                    error = true;
                }
            });
        }

            return error;

    }

    function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
    }
</script>