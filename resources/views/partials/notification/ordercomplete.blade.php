<div class="modal fade show" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div style="min-height: 200px; background: #6db07f;">
                <img src="{{asset('assets/images/good.png')}}" alt="" style="margin: 10px auto;">
            </div>
            <div style="min-height: 200px;padding-top: 15px; text-align: center;">
                <h5 style="color: #6db07f;">Success</h5>
                <h2>Order Complete</h2>
                <a href="{{route('ordercomplete', ['id' => ''])}}" id="order_receipt" style="color: #6db07f;">
                    <button type="button" class="btn btn-large btn-primary">View receipt</button>
                </a>
            </div>


        </div>

    </div>
</div>