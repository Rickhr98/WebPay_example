<?php

namespace App\Http\Controllers;

use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

use Illuminate\Http\Request;

class WebpayPlusController extends Controller
{
    public function __construct(){
        if (app()->environment('production')) {
            WebpayPlus::configureForProduction(config('services.transbank.webpay_plus_cc'), config('services.transbank.webpay_plus_api_key'));
        } else {
            WebpayPlus::configureForTesting();
        }
    }

    public function index(){
        
        $id_order = 1;
        $amount = 100;
        $sessionId = 1;

        return view('welcome',[
            'id_order'=>$id_order,
            'session_id'=>$sessionId,
            'amount'=>$amount
        ]);
    }

    public function createdTransaction(Request $request)
    {
        //RECOMENDACION:
        //En esta funcion se debe recibir el id_order como parametros
        //y con ese Id se debe buscar en la db los parametro de monto a pagar(amount) y el id del cliente (session_id) para crear la transaccion
        //EJEMPLO:
        /*
        $datos = request();
        //recibiendo $id_order por POST
        //Obtener la orden
        //Recordar Importar el modelo de order
        $order = order::getOrderByID($datos['buy_order']);

        //Obtener el monto
        $amount = $order->totalprice;

        //Obtener el id del usuario
        $sessionId = $order->id_user;

        //id de la orden
        $id_order = $id_order;
        */

        $req = $request->except('_token');
        $resp = (new Transaction)->create($req["buy_order"], $req["session_id"], $req["amount"], $req["return_url"]);
        return view('transaction_created', [ "params" => $req,"response" => $resp]);
    }

    public function commitTransaction(Request $request)
    {
        $req = $request->except('_token');
        //TBK_TOKEN se genera cuando el usuario ingresa en el flujo de pago en la pagina de transbank y anula la operacion

        if(!empty($req['token_ws'])){
            $resp = (new Transaction)->commit($req["token_ws"]);
            if($resp->responseCode == 0 && !empty($resp->authorizationCode)){
                //pedido pagado
                //se debe cambiar el status del pedido a pagado
                //enviar un correo de confirmacion al cliente    
            }
        }elseif(!empty($req['TBK_TOKEN'])){
            //el usuario le dio a anular la operacion desde la plataformar de transbank
            $resp = false;
        }else{
            $resp = false;
        }
        return view('transaction_committed', ["resp" => $resp, "req" => $req]);
    }


    public function showRefund()
    {
        return view('webpayplus/refund');
    }

    public function refundTransaction(Request $request)
    {
        $req = $request->except('_token');
        
        $resp = WebpayPlus\Transaction::refund($req["token"], $req["amount"]);

        return view('webpayplus/refund_success', ["resp" => $resp]);
    }

    public function getTransactionStatus(Request $request)
    {
        $req = $request->except('_token');
        $token = $req["token"];

        $resp = WebpayPlus\Transaction::status($token);

        return view('webpayplus/transaction_status', ["resp" => $resp, "req" => $req]);
    }
}
