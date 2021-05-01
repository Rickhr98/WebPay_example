<div>
        @if (isset($req['TBK_TOKEN']) && $resp == false)
            <span class="text-red-700 text-xl my-2 inline-block font-bold">Anuló la operacion; si desea reintentar el pago haga click en <b>"Reintentar Pago"</b></span>
            <!--INICIO DE FOMRULARIO PARA REDIRECCION AL INICIO DE LA COMPRA-->
            <!--<a href="{{ url('/order/webpay/create/'.$req['TBK_ORDEN_COMPRA']) }}">Reintentar pago</a>-->
            <a href="{{ url('/order/webpay/create') }}">Reintentar pago</a>

        @elseif($resp == false && !isset($req['TBK_TOKEN']))
            <span class="text-red-700 text-xl my-2 inline-block font-bold">La operacion se cerro por inactividad; si desea reintentar el pago haga click en <b>"Reintentar Pago"</b></span>
            <!--INICIO DE FOMRULARIO PARA REDIRECCION AL INICIO DE LA COMPRA-->
            <!--<a href="{{url('/order/webpay/create/'.$req['TBK_ORDEN_COMPRA'])}}">Reintentar pago</a>-->
            <a href="{{ url('/order/webpay/create') }}">Reintentar pago</a>

        @elseif(!empty($req['token_ws']) && $resp != false)
            @if($resp->responseCode == 0 && !empty($resp->authorizationCode))

                <span class="text-red-700 text-xl my-2 inline-block font-bold">Operacion Exitosa</span>

                <p style="text-align: center; font-size: 12px; color: #c4c4c4; margin-top: 20px;">Será redirigido en 5 segundos...</p>
            @else

                <span class="text-red-700 text-xl my-2 inline-block font-bold">Operacion Rechazada, por favor verifique los datos ingresados</span>
                <!--INICIO DE FOMRULARIO PARA REDIRECCION AL INICIO DE LA COMPRA-->
                <!--<a href="{{url('/order/webpay/create/'.$resp->buyOrder)}}">Reintentar pago</a>-->
                <a href="{{ url('/order/webpay/create') }}">Reintentar pago</a>
            @endif

        @endif
    </div>