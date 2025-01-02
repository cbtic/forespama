<title>FORESPAMA</title>

<style>
@page {
    margin-left: 1cm;
    margin-right: 1cm;
}
.container {
    position: relative;
    height: 100vh; /* Establece la altura del contenedor al 100% de la altura de la ventana del navegador */
    left: 570px;
    top: -100px;
}
.two-columns {
        column-count: 2;      /* Divide el contenido en dos columnas */
        column-gap: 40px;    /* Espacio entre las dos columnas */
    }

.table-condensed {
  width: 250px;
  height:250px;
}

.p{
    font-size: 8.5;
}

.td{
    font-size:11px
}

table.data {
    border-collapse:separate;
    border:solid black 1px;
    border-radius:8px;
    padding: 3px;
    border-spacing: 0;
}

td.data, th.data {
    border-left:solid black 1px;
    border-top:solid black 1px;
    text-align:center;
    border-top: none;
    font-size:11px;
}

.modal-dialog {
	width: 100%;
	max-width:60%!important
  }
  
#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 11px;
    height: 3.5vh !important;
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
}

table {
    width: 100%;
    border-collapse: separate; /* Importante para las esquinas redondeadas */
    border-spacing: 0; /* Para eliminar el espacio entre celdas */
    font-family: Arial, sans-serif;
}

th {
    text-align: left;
    padding: 8px;
    vertical-align: top;
    border: none; /* Sin borde por defecto */
}

th:last-child {
    border: solid 2px black; /* Solo el borde de la última celda */
    border-radius: 8px; /* Aplica esquinas redondeadas a la última celda */
    background-color: white; /* Color de fondo para visualizar las esquinas redondeadas */
}

.info-empresa{
    font-size: 8.5px; 
    font-weight: normal; 
    margin: 0; 
    line-height: 1;
}

.info-guia{
    font-size: 10px; 
    font-weight: normal; 
    margin: 0; 
    line-height: 1;
}

</style>


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<script type="text/javascript">


</script>

<body class="hold-transition skin-blue sidebar-mini">

    <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
        <tr>
            <th style="text-align: left; border: none; width: 10%;">
                <img width="120px" height="50px" src="img/logo_forestalpama.jpg" alt="Logo Forestal PAMA">
            </th>
            <th style="text-align: center; border: none; vertical-align: top; padding: 0px; width: 40%"> <!-- Alineación vertical ajustada -->
                <h1 style="font-size: 20px;"><strong>FORESTAL PAMA S.A.C.</strong></h1>
                <p class="info-empresa">FABRICACION Y COMERCIALIZACION DE PRODUCTOS EN MADERA,</p>
                <p class="info-empresa">VENTA DE PUERTAS DE MADERA PARA INTERIOR, EXTERIOR</p>
                <p class="info-empresa">MARCOS, TABLEROS Y SERVICIOS AFINES</p>
                <p style="margin: 4px 0;"></p>
                <p class="info-empresa">Antigua Panamericana Sur Km. 17.5 Villa el Salvador</p>
                <p class="info-empresa">La Concordia Mz. B Lt. 15 Villa el Salvador</p>
                <p style="margin: 4px 0;"></p>
                <p class="info-empresa">DOM. FISCAL: Carretera Marginal Km. 42 Sector Miraflores s/n</p>
                <p class="info-empresa">Oxapampa - Oxapampa - Pasco</p>
                <p style="margin: 4px 0;"></p>
                <p class="info-empresa">Telf: 967355287 / 963340534 / 992665247 / 963 338 524</p>
                <p class="info-empresa">Email: forestalpama-sac@hotmail.com</p>
            </th>
            <th style="text-align: center; border: solid 2px black; padding: 0px; border-radius: 8px; background-color: white; vertical-align: top; width: 50%">
                <p style="font-size: 20px; margin: 10; line-height: 1;">R.U.C. 20486785994</p>
                <div style="background-color: lightgray; padding: 5px; border-radius: 4px; margin: 10px 0;">
                    <p style="font-size: 20px; margin: 0; line-height: 1;">PROFORMA</p>
                </div>
                <p style="font-size: 20px; margin: 10; line-height: 1;"><?php echo $serie;?>.- N° <?php echo str_pad($numero, 6, '0', STR_PAD_LEFT);?></p>
            </th>
        </tr>
    </table>
   
    <!--<table class="data" style="width:30%; font-size:11px">
        <tr>
            <th><h2>Guia de Remisi&oacute;n<?php //echo ' N° ' .$codigo;?></h2></th>
        </tr>
    </table>
    <hr>-->
    &nbsp;
    <table style="width:100%; background-color:white !important;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px; vertical-align:top">
        <tbody>
            <tr>
                <td class="td" style ="text-align: left; width: 10%;">Fecha:</td>
                <td class="td" style ="text-align: left; width: 20%;"><?php echo $fecha;?></td>
            </tr>   
        </tbody>
    </table>
    <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
        <tr>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">Cliente: <?php echo $cliente_nombre;?></p>
            </th>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">RUC / DNI: <?php echo $cliente_numero_documento;?></p>
            </th>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">Moneda: <?php echo $moneda;?></p>
            </th>
        </tr>
        <!--<tr>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">Sub Total: <?php //echo $sub_total;?></p>
            </th>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">IGV: <?php //echo $igv;?></p>
            </th>
            <th style="text-align: left; border: solid 1px black; border-radius: 8px; background-color: white; vertical-align: top; width: 49%">
                <p class="info-guia">Total: <?php //echo $total;?></p>
            </th>
        </tr>-->
    </table>

            &nbsp;
            <table class="data" style="border-collapse: separate; border-spacing: 0; background-color:white !important; width: 100%; border-radius: 8px; font-size:11px">
                <tbody>
                    <tr class="data">
                        <td class="td" style ="text-align: left; width: 5%; height:5px; border-bottom: 1px solid black;"><b>#</b></td>
                        <td class="td" style ="text-align: left; width: 10%; height:10px; border-bottom: 1px solid black;"><b>C&Oacute;DIGO</b></td>
                        <td class="td" style ="text-align: left; width: 35%; height:25px; border-bottom: 1px solid black;"><b>DESCRIPCI&Oacute;N</b></td>
                        <td class="td" style ="text-align: left; width: 10%; height:10px; border-bottom: 1px solid black;"><b>UNIDAD</b></td>
                        <td class="td" style ="text-align: left; width: 10%; height:10px; border-bottom: 1px solid black;"><b>CANTIDAD</b></td>
                        <td class="td" style ="text-align: left; width: 10%; height:10px; border-bottom: 1px solid black;"><b>PRECIO UNITARIO</b></td>
                        <td class="td" style ="text-align: left; width: 10%; height:10px; border-bottom: 1px solid black;"><b>SUB TOTAL</b></td>
                        <td class="td" style ="text-align: left; width: 5%; height:10px; border-bottom: 1px solid black;"><b>IGV</b></td>
                        <td class="td" style ="text-align: left; width: 5%; height:10px; border-bottom: 1px solid black;"><b>TOTAL</b></td>
                    </tr>
                    
                    <?php 
                    $subtotal_suma=0;
                    $igv_suma=0;
                    $total_suma=0;
                    foreach($datos_detalle as $key=>$r) { ?>
                        <tr>
                            <td class="td" style ="text-align: left; width: 5%; height:25px"><?php echo $r->row_num;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->codigo_producto;?> </td>
                            <td class="td" style ="text-align: left; width: 25%; height:25px"><?php echo $r->producto; if($id_cliente==$r->id_empresa) echo " (".$r->codigo_empresa." - ".$r->descripcion_empresa.")"?> </td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->unidad_medida;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->cantidad;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->precio_unitario;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->sub_total;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->igv;?></td>
                            <td class="td" style ="text-align: left; width: 10%; height:25px"><?php echo $r->total;?></td>
                            <?php 
                            $subtotal_suma+=$r->sub_total;
                            $igv_suma+=$r->igv;
                            $total_suma+=$r->total;
                            ?>
                        </tr>
                    <?php 
                    }

                    use Luecano\NumeroALetras\NumeroALetras;

                    $numeroALetras = new NumeroALetras();
                    $total_en_letras =$numeroALetras->toInvoice( $total_suma, 2, 'Soles');
                    ?>
                </tbody>
            </table>
             &nbsp;
            <table class="data" style="border-collapse: separate; border-spacing: 0; background-color:white !important; border-radius: 8px; font-size:11px; margin: 0 0 0 auto">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 33%; height:25px;"><b>SUB TOTAL: <?php echo number_format($subtotal_suma,2,'.',',');?></b></td>
                        <td class="td" style ="text-align: left; width: 33%; height:25px;"><b>IGV:<?php echo number_format($igv_suma,2,'.',',');?></b></td>
                        <td class="td" style ="text-align: left; width: 33%; height:25px"><b>TOTAL:<?php echo number_format($total_suma,2,'.',',');?></b></td>
                    </tr>
                </tbody>
            </table>
            &nbsp;
            
            <table class="data" style="width:100%">
                <tr>
                    <td>SON: <?php echo $total_en_letras; ?></td>
                </tr>
            </table>
            &nbsp;
            
        </div>
    </div>
    <!-- /.content-wrapper -->
    
@push('after-scripts')

<script src="{{ asset('js/proforma.js') }}"></script>

@endpush

<script>

function showMessage() {
    return "hola";
}

function Unidades(num){

switch(num)
{
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
}

return "";
}//Unidades()

function Decenas(num){

decena = Math.floor(num/10);
unidad = num - (decena * 10);

switch(decena)
{
    case 1:
        switch(unidad)
        {
            case 0: return "DIEZ";
            case 1: return "ONCE";
            case 2: return "DOCE";
            case 3: return "TRECE";
            case 4: return "CATORCE";
            case 5: return "QUINCE";
            default: return "DIECI" + Unidades(unidad);
        }
    case 2:
        switch(unidad)
        {
            case 0: return "VEINTE";
            default: return "VEINTI" + Unidades(unidad);
        }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
}
}//Unidades()

function DecenasY(strSin, numUnidades) {
if (numUnidades > 0)
return strSin + " Y " + Unidades(numUnidades)

return strSin;
}//DecenasY()

function Centenas(num) {
centenas = Math.floor(num / 100);
decenas = num - (centenas * 100);

switch(centenas)
{
    case 1:
        if (decenas > 0)
            return "CIENTO " + Decenas(decenas);
        return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
}

return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural) {
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

letras = "";

if (cientos > 0)
    if (cientos > 1)
        letras = Centenas(cientos) + " " + strPlural;
    else
        letras = strSingular;

if (resto > 0)
    letras += "";

return letras;
}//Seccion()

function Miles(num) {
divisor = 1000;
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

strMiles = Seccion(num, divisor, "UN MIL", "MIL");
strCentenas = Centenas(resto);

if(strMiles == "")
    return strCentenas;

return strMiles + " " + strCentenas;
}//Miles()

function Millones(num) {
divisor = 1000000;
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

strMillones = Seccion(num, divisor, "UN MILLON DE", "MILLONES DE");
strMiles = Miles(resto);

if(strMillones == "")
    return strMiles;

return strMillones + " " + strMiles;
}//Millones()

function NumeroALetras(num) {
var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
    letrasMonedaPlural: '',//"PESOS", 'Dólares', 'Bolívares', 'etcs'
    letrasMonedaSingular: '', //"PESO", 'Dólar', 'Bolivar', 'etc'

    letrasMonedaCentavoPlural: "CENTAVOS",
    letrasMonedaCentavoSingular: "CENTAVO"
};

if (data.centavos > 0) {
    data.letrasCentavos = "CON " + (function (){
        if (data.centavos == 1)
            return Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular;
        else
            return Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural;
        })();
};

if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
}//NumeroALetras()

</script>



