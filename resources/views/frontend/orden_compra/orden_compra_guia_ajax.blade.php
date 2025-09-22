<table id="tblOrdenCompra" class="table table-hover table-sm">
<thead>
	<tr style="font-size:13px">
		<th width="10%">Id</th>
		<th width="25%">Fecha</th>
		<th width="25%">Serie-N&uacute;mero</th>
		<th width="20%">Archivo</th>
		<th width="20%">Editar</th>
	</tr>
</thead>
<tbody>
<?php 

$total_importe=0;

if($guia){

foreach($guia as $row){

?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" title="<?php if($row->observacion_recepcion!="")echo "Observacion: ".$row->observacion_recepcion ?>">
	<td class="text-left"><?php echo $row->id?></td>
	<td class="text-left" style="min-width: 80px!important;"><?php echo $row->fecha_traslado?></td>
    <td class="text-left"><?php echo $row->serie_numero?></td>
	<td class="text-left">
	<?php if($row->ruta_imagen!=""){?>
		<a href="/img/guia_orden_compra/<?php echo $row->id_orden_compra?>/<?php echo $row->ruta_imagen?>" target="_blank" class="btn btn-sm btn-info">Ver</a>
	<?php }?>
	</td>
	<td class="text-left">
		<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalGuia(<?php echo $row->id?>,'')" >Editar</button>
	</td>
</tr>
<?php
	}
}
?>
</tbody>

</table>
