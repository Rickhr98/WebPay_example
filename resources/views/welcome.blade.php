<h2>Transaccion de webpay</h2>
<form class="webpay_form" action="{{url('/order/webPay/init')}}" method="post" id='webpay-init' style="display: flex; flex-direction:column; width:50%;font-size: 20px;">
    @csrf
    <label for="buy_order">Id de la orden</label>
    <input type="number" id="buy_order" name="buy_order" value="{{$id_order}}" readonly/>
    <br/>
    <label for="session_id">Session id</label>
    <input type="number" id="session_id" name="session_id" value="{{$session_id}}" readonly/>
    <br/>
    <label for="return_url">Return_url</label>
    <input type="text" id="return_url" name="return_url" value="{{ url('/') }}/webpayplus/returnUrl" readonly/>
    <br/>
    <label for="amount">Amount</label>
    <input type="text" id="return_url" name="amount" value="{{$amount}}" readonly/>
    <br/>
    <input type="submit" value="Pagar">
</form>
