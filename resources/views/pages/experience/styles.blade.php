<style>
    input.date {
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        text-decoration: inherit;
    }
    .intl-tel-input{
        width: 100%
    }
    input[type=range] {
        display: inline;
        width: 80px;
    }
    /*select#exp_country {*/
    /*width: auto;*/
    /*}*/
    /*.search_exp_btn{*/
    /*display: block;*/
    /*margin: 20px auto;*/
    /*}*/
    a, a:hover{
        color: #fff;
    }
    .experience_page_container{
        background: none;
    }
    body{
        background: #fff;
    }
    .flatpickr-input{
        /*visibility: hidden;*/
        display: none;
    }
    .availability_details{
        margin-top: 30px;
        padding: 10px;
        background: #fff;
        font-size: 14px;
        height: 150px;
        line-height: 24px;
        border-radius: 5px;
        -webkit-box-shadow: 1px 0 0 #e6e6e6, -1px 0 0 #e6e6e6, 0 1px 0 #e6e6e6, 0 -1px 0 #e6e6e6, 0 3px 13px rgba(0,0,0,0.08);
        box-shadow: 1px 0 0 #e6e6e6, -1px 0 0 #e6e6e6, 0 1px 0 #e6e6e6, 0 -1px 0 #e6e6e6, 0 3px 13px rgba(0,0,0,0.08);
        opacity: 0;
        transform: translateY(-40px);
        -webkit-transition: transform 300ms linear;
        -moz-transition: transform 300ms linear;
        -ms-transition: transform 300ms linear;
        -o-transition: transform 300ms linear;
        transition: transform 300ms linear;
    }
    .availability_details_show{
        opacity: 1;
        transform: translateY(0px);
    }

    .availability_details_show_reverse{
        opacity: 0.2;
        transform: translateY(-10px);
    }
    .img-responsive{
        border-radius: 5px;
    }
    .experience_modal_details{
        display: flex;
        justify-content: space-between;
    }
    .experience_modal_details .details{
        margin: auto 40px;
    }
    .experience_modal_details .image{
        width: 104px;
        height: 104px;
        margin: auto 40px;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(80,80,80,.3);
        background-size: cover;
        background-position: 50%;
        background-repeat: no-repeat;
        -webkit-box-shadow: 1px 0 0 #e6e6e6, -1px 0 0 #e6e6e6, 0 1px 0 #e6e6e6, 0 -1px 0 #e6e6e6, 0 3px 13px rgba(0,0,0,0.08);
        box-shadow: 1px 0 0 #e6e6e6, -1px 0 0 #e6e6e6, 0 1px 0 #e6e6e6, 0 -1px 0 #e6e6e6, 0 3px 13px rgba(0,0,0,0.08);
    }
    .modal .modal-header {
        height: 50px;
    }
    .experience_modal_price_options{
        margin-top: 30px;
    }
    .price_option_item{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        padding: 10px 0px;;
    }
    .price_options{
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    .sendformdiv{
        padding: 10px;
    }
    .panel-title, .other_forms{
        text-align: left;
    }
    .participant_form{
        text-align: left;
        padding: 10px;
    }
    .participant_form .form-control, .booking_form .form-control{
        margin-bottom: 10px
    }
    .panel-default>.panel-heading {
        color: #fff;
        background-color: #45a6c4;
        border-color: #ddd;
    }
</style>