<script>
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



                booking_form +='<div class="row">';
                booking_form +='<div class="col-12 col-md-6">';
                booking_form +=' <p>First Name: </p>';
                booking_form +='<input class="form-control" name="FirstName">';
                booking_form +='</div>';
                booking_form +=' <div class="col-12 col-md-6">';
                booking_form +='<p>Middle Name: </p>';
                booking_form +='<input class="form-control" name="MiddleName">';
                booking_form +=' </div>';
                booking_form +='<div class="col-12 col-md-6">';
                booking_form +='<p>Last Name: </p>';
                booking_form +='<input class="form-control" name="LastName">';
                booking_form +='</div>';
                booking_form +=' <div class="col-12 col-md-6">';
                booking_form +=' <p>Date of Birth: </p>';
                booking_form +='<input class="form-control" type="date" name="DateOfBirth">';
                booking_form +='  </div>';
                booking_form +='  <div class="col-12 col-md-6">';
                booking_form +=' <p>Age: </p>';
                booking_form +=' <input class="form-control" type="number" name="Age">';
                booking_form +=' </div>';
                booking_form +=' <div class="col-12 col-md-6">';
                booking_form +='<p>Phone Number: </p>';
                booking_form +='<input class="form-control" type="number" name="PhoneNumber">';
                booking_form +='   </div>';
                booking_form +='  <div class="col-12 col-md-6">';
                booking_form +='  <p>Passport No: </p>';
                booking_form +=' <input class="form-control" name="PassportNumber">';
                booking_form +='</div>';
                booking_form +='<div class="col-12 col-md-6">';
                booking_form +=' <p>Passport Expiry Date: </p>';
                booking_form +='<input class="form-control" type="date" name="ExpiryDate">';
                booking_form +='  </div>';
                booking_form +=' <div class="col-12 col-md-6">';
                booking_form +='<p>Passport Issuing Authority: </p>';
                booking_form +='<input class="form-control" name="PassportIssuingAuthority">';
                booking_form +='</div>';
                booking_form +=' </div>';


            }
        })
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
        for(i = 1; i <= participants_count; i++) {
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
            // return form;
        }
        return form;
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