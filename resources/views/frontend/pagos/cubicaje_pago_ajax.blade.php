<table id="tblCubicaje" class="table table-hover table-sm">
<thead>
	<tr style="font-size:13px">
		<th width="2%">Id</th>
		<th width="10%">Fecha</th>
		<th width="10%">Tipo Doc</th>
		<th width="10%">Guia</th>
		<th width="10%">Factura</th>
		<th width="10%">Importe</th>
		<th width="10%">Archivo</th>
		<th width="10%">Editar</th>
	</tr>
</thead>
<tbody>
<?php 

$total_importe=0;

if($pago){

$total_importe=0;
/*
$volumen_total_m3=0;
$volumen_total_pies=0;
$precio_total=0;
$cantidad_cubicaje=0;
*/
foreach($pago as $row){
	
	$total_importe += $row->importe;
	/*
	$volumen_total_m3 += $row->volumen_total_m3;
	$volumen_total_pies += $row->volumen_total_pies;
	$precio_total += $row->precio_total;
	$cantidad_cubicaje += $row->cantidad;
	*/
?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" title="<?php if($row->observacion!="")echo "Observacion: ".$row->observacion ?>">
	<td class="text-left"><?php echo $row->id?></td>
	<td class="text-left" style="min-width: 80px!important;"><?php echo $row->fecha?></td>
	<td class="text-left"><?php echo $row->tipodesembolso?></td>
	<td class="text-left"><?php echo $row->nro_guia?></td>
	<td class="text-left"><?php echo $row->nro_factura?></td>
    <td class="text-right"><?php echo $row->importe?></td>
	<td class="text-right">
	<?php if($row->foto_desembolso!=""){?>
		<a href="/img/pago/<?php echo $row->foto_desembolso?>" target="_blank" class="btn btn-sm btn-info">Ver</a>
	<?php }?>
	</td>
	<td class="text-right">
		<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalPago(<?php echo $row->id?>,'')" >Editar</button>';
	</td>
	<td class="text-left">
		<button style="font-size:12px" type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="eliminarPago(<?php echo $row->id?>,'')" >Eliminar</button>
	</td>
</tr>
<?php
	}
} 
?>
</tbody>

<tfoot>
	<tr>
		<th class="text-center">Total</th>
		<th colspan="4"></th>
		<th class="text-right" style="padding-right:0px"><?php echo $total_importe?></th>
	</tr>
</tfoot>

</table>
