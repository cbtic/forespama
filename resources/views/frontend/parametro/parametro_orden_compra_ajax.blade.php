<table id="tblValidaParametro" class="table table-hover table-sm">
<thead>
	<tr style="font-size:13px">
		<th width="10%">Id Orden Compra</th>
		<th width="10%">Valor Total</th>
		<th width="20%">Parametro</th>
		<th width="10%">Valor</th>
		<th width="20%">Aplica Parametro</th>
		<th width="20%">Estado</th>
	</tr>
</thead>
<tbody>
<?php 

if(!empty($parametro_orden_compra)){

/*
$volumen_total_m3=0;
$volumen_total_pies=0;
$precio_total=0;
$cantidad_cubicaje=0;
*/
foreach($parametro_orden_compra as $row){
	
	/*
	$volumen_total_m3 += $row->volumen_total_m3;
	$volumen_total_pies += $row->volumen_total_pies;
	$precio_total += $row->precio_total;
	$cantidad_cubicaje += $row->cantidad;
	*/
	$total_valor = $row->total*($row->valor/100);
?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" title="<?php //if($row->observacion!="")echo "Observacion: ".$row->observacion ?>">
	<td class="text-left"><?php echo $row->id_orden_compra?></td>
	<td class="text-left"><?php echo $row->total?></td>
	<td class="text-left"><?php echo $row->nombre_acuerdo_comercial?></td>
	<td class="text-left"><input type="text" name="valor[]" class="form-control form-control-sm" value=" <?php echo $total_valor?>"></td>
	<td class="text-center"><input type="checkbox" name="aplica_parametro[]" class="form-check-input" value="1" <?php echo ($row->aplica_parametro == 1) ? 'checked disabled' : ''; ?>></td>
    <td class="text-left"><select name="estado_validacion[]" class="form-control form-control-sm"><option value="0" <?php echo ($row->estado_validacion == 0) ? 'selected' : ''; ?>>Pendiente</option><option value="1" <?php echo ($row->estado_validacion == 1) ? 'selected' : ''; ?>>Cerrado</option></select>
	</td>
</tr>
<?php
	}
} 
?>
</tbody>

<tfoot>
	<tr>
		<td  colspan="6" class="text-right">
			<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="save()" >Guardar</button>
		</td>
	</tr>
</tfoot>

</table>
