
<!DOCTYPE html>
<html>
<head>
<title>Comprobante</title>
   
<style type="text/css">

*{
    /* border: 1px solid red; */
    font-family: Arial, Helvetica, sans-serif;
}
p {
    margin:5px;
}
.pre-header{
    border: 0px solid #cdcdcd;
    text-align: center;
    font-size: 1.2rem;
}
.pre-header>div{
    padding: 5px;
}
.header{
    position: relative;
    width: 100%;
}
.header>table{
    width: 100%;
    border: 0px solid #cdcdcd;
}

.logo>img{
    max-width: 200px;
    max-height: 50px;
    object-fit: contain;
}

.header-col{
    font-size: 0.8rem;
    padding-left: 10px;

}

.header-col>div{
    height: 20px;
}

.header-col>.title{
    font-size: 1.1rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;    
}

.image{
    max-height: 80px;
    margin-right: 20px
}

.col-left{
    width: 20%;
    border-right: 0px solid #cdcdcd;

}
.col-rigth{
    padding-left: 35px;

}

.letra {
    position: absolute;
    top: 0px;
    left: 50%;
    width: 60px;
    text-align: center;
    margin-left: -32px;
    padding: 0px 0px;
    height: 45px;
    z-index: 1000;
    border: 0px solid #cdcdcd;
    background: white;
    font-size: 32px;
    line-height: 20px;
    padding-top:10px;
}

.letra-code {
    font-size: 12px;
    font-weight: bold;

}


.subheader{
    margin: 0px;
    font-size: 0.8rem;
    /* width: 100%; */
    border: 0px solid #cdcdcd;
    position: relative
}
.subheader>table{
    width: 100%;
    padding: 10px;
}
.subheader>table>tr>td{
    font-size: 0.8rem;
    height: 33%;
}
.destinatario{
    margin: 0px;
    border: 0px solid #cdcdcd;
    font-size: 1rem;
    padding: 10px;

}
.destinatario>table{
    width: 100%;

}
.destinatario>table>tr>td{
    width: 50%!important;
}

.mt-4 {
    margin-top:4px;
}

.mt-10 {
    margin-top:10px;
}

.mt-30 {
    margin-top:30px;
}

.box-pago{
    margin-bottom: 10px;
}

.detalle{
    font-size: 0.8rem;
    height: 45%;
}
.detalle>table{
    width: 100%;
    

}
.detalle>table>thead>tr>th{
    background-color: #cdcdcd;
    padding: 10px 0px;
    font-size:10px;
}

.detalle_items{
    text-align: center;
    font-size:11px;
}
.producto_servicio{
    text-align: left;
}
.totales{
    font-size: 0.9rem;
}
.totales>table{
    width: 100%;
    border: 0px solid #cdcdcd;
}
.totales>table{
    padding: 10px;
    font-size: 0.8rem;
}
.text-right{
    text-align: right;    
}

.text-center{
    text-align: center;    
}

.text-justify{
    text-align: justify;    
}

.text-line-20{
    line-height:2.0;
}

.left-td{
    text-align: right;
    width: 80%;
}
.footer{
    font-size: 0.8rem;
}
.footer>table{
    width: 100%;

}
.footer>table{
    padding: 10px;
}
.text-logo{
    text-align: center;
    font-weight: bold;
    font-size: 24px;
    margin-bottom: 25px;
}

.w-5{
    width: 5%;
}
.w-15{
    width: 15%;
}
.w-50{
    width: 50%;
}


</style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td><strong>DESARROLLO SOCIAL</strong></td>
                <td class="text-right"> <img class="image" src="{{ public_path('images/logos/mvl.jpg') }}"> </td>
            </tr>
        </table>
    </div>
    <br><br>
    <div class="header">
        <table>
            <tr>
                <td class="col-left">
                     <div class="header-col">
                        <div class="mt-10"><strong>N° de Tramite:</strong>  </div>
                        <div class="mt-10"><strong>Fecha:</strong>  </div>
                        <div class="mt-10"><strong>Titular: </strong> </div>
                        <div class="mt-10"><strong>N° de Documento: </strong>  </div>
                        <div class="mt-10"><strong>Domicilio: </strong>  </div>
                        @if ($phone)
                            <div class="mt-10"><strong>Telefono: </strong>  </div>
                        @endif
                        @if ($celular)
                            <div class="mt-10"><strong>Celular: </strong>  </div>
                        @endif
                         @if ($cud_codigo)
                            <div class="mt-10"><strong>Codigo CUD: </strong>  </div>
                        @endif
                        @if ($cud_diagnostico)
                            <div class="mt-10"><strong>Diagnostico: </strong>  </div>
                        @endif
                        <div class="mt-10"><strong>Dependencia: </strong>  </div>
                        <div class="mt-10"><strong>Modalidad Atención: </strong>  </div>
                        <div class="mt-10"><strong>Tipo de Tramite: </strong>  </div>
                        <div class="mt-10"><strong>Observación: </strong>  </div>
                    </div>
                </td>
                <td class="col-rigth">
                    <div class="header-col">
                        <div class="mt-10">{{$num_tramite}}</div>
                        <div class="mt-10">{{$fecha}}</div>
                        <div class="mt-10">{{$titular}}</div>
                        <div class="mt-10">{{$num_documento}}</div>
                        @if ($domicilio)
                            <div class="mt-10">{{$domicilio}}</div>
                        @else
                            <div class="mt-10">-</div>
                        @endif
                        @if ($phone)
                            <div class="mt-10">{{$phone}}</div>
                        @endif
                        @if ($celular)
                            <div class="mt-10">{{$celular}}</div>
                        @endif
                        @if ($cud_codigo)
                            <div class="mt-10">{{$cud_codigo}}</div>
                        @endif
                        @if ($cud_diagnostico)
                            <div class="mt-10">{{$cud_diagnostico}}</div>
                        @endif
                        <div class="mt-10">{{$dependencia}}</div>
                        <div class="mt-10">{{$modalidad_atencion}}</div>
                        <div class="mt-10">{{$tipo_tramite}}</div> 
                        <div class="mt-10">{{$observacion}}</div> 
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="destinatario">
        <table>
            <tr>
                <td class="text-center"><div class="mt-30"><strong>PROXIMA ATENCION</strong></div></td>
            </tr>
           <tr>
                <td class="text-center"><div class="mt-30"><strong>PERSONAL INTERVINIENTE</strong></div></td>
            </tr>
            <tr>
                <td class="text-center"><div class="mt-30"><strong>FECHA</strong></div></td>
            </tr>
        </table>            
    </div>

    <div class="header" style="page-break-before: always;">
        <table>
            <tr>
                <td><strong>DESARROLLO SOCIAL</strong></td>
                <td class="text-right"> <img class="image" src="{{ public_path('images/logos/mvl.jpg') }}"> </td>
            </tr>
        </table>
    </div>
    @if (count($comments) > 0)
    <br><br>
        <div class="header">
        <table class="header-col">
        <thead>
            {{-- <tr>
                <th class="col-left">
                    Detalle
                </th>
                <th class="col-center">
                    Comentario
                </th>
            </tr> --}}
        </thead>
        <tbody>
        
        @foreach ($comments as $comment )
        <br>
            <tr>
                <td class="text-center text-line-20 mt-10">
                   <b>{{$comment->created_at->format('d/m/Y H:i:s')}}</b>
                </td>
                <td class="text-center text-line-20 mt-10">
                    <b>{{$comment->dependencia['description']}}</b>
                </td>
                <td class="text-center text-line-20 mt-10">
                    <b>{{$comment->user['name']}}</b>
                </td>
            </tr>
            <tr>
                <td class="text-justify mt-4" colspan="3">
                    {{$comment->content}}
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    @else
        <p>El tramite no posee comentarios.</p>
    @endif
    
    <br><br>
    
</body>
</html>