
    <form method="post" id="url-webpay" action="{{$response->getUrl()}}">
        @csrf
        <input type="hidden" name="token_ws" value="{{$response->getToken()}}" />
    </form>
 


    <script> document.getElementById('url-webpay').submit(); </script>