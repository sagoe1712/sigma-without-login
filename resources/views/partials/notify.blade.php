<div class="overlay">
    <div class="textnotify_container ">
        <div class="textnotify animated fadeInDown">
            <span>{{$text}}</span> 
            <span>
            <button type="button" class="close_overlay" data-dismiss="modal" aria-label="Close"
            style="opacity: 1;color: #fff; margin-top: 15px;padding-right: 15px;">
            <span aria-hidden="true">&times;</span></button></span>
        </div>
    </div>
</div>

<script>
    swal("",'{{$text}}', "error");
</script>