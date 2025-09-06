<table id="tblCubicaje" class="table table-hover table-sm">
<thead>
	<tr style="font-size:13px">
		<th width="2%">#</th>
		<th width="2%">Cantidad</th>
		<th width="10%">Diametro 1(cm)</th>
		<th width="10%">Diametro 2(cm)</th>
		<th width="10%">Diametro DM(m)</th>
		<th width="10%">Longitud(m)</th>
		<th width="10%">Volumen M3</th>
		<th width="10%">Volumen Pies</th>
		<th width="10%">Volumen Total M3</th>
		<th width="10%">Volumen Total Pies</th>
		<th width="10%">Precio Unitario</th>
		<th width="10%">Precio Total</th>
	</tr>
</thead>
<tbody>
<?php 
if($cubicaje){
$volumen_pies=0;
$volumen_total_m3=0;
$volumen_total_pies=0;
$precio_total=0;
$cantidad = 1;

foreach($cubicaje as $row){
	$volumen_pies += $row->volumen_pies;
	$volumen_total_m3 += $row->volumen_total_m3;
	$volumen_total_pies += $row->volumen_total_pies;
	$precio_total += $row->precio_total;
?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top">
	<td class="text-left"><?php echo $cantidad ?></td>
	<td class="text-center">1<input type="hidden" name="id_ingreso_vehiculo_tronco_cubicaje[]" value="<?php echo $row->id?>" /><input type="hidden" name="id_empresa_proveedor[]" value="<?php echo $row->id_empresa_proveedor?>" /><input type="hidden" name="diametro_dm_[]" value="<?php echo $row->diametro_dm_proveedor?>" /><input type="hidden" name="precio_mayor[]" value="<?php echo $row->precio_mayor?>" /><input type="hidden" name="precio_menor[]" value="<?php echo $row->precio_menor?>" /></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="diametro_1[]" value="<?php echo ($row->diametro_1!=0)?$row->diametro_1:""?>" onKeyUp="calcular_cubicaje(this)"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="diametro_2[]" value="<?php echo ($row->diametro_2!=0)?$row->diametro_2:""?>" onKeyUp="calcular_cubicaje(this)"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="diametro_dm[]" value="<?php echo ($row->diametro_dm!=0)? number_format($row->diametro_dm,3):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="longitud[]" value="<?php echo ($row->longitud==0)?2.44:$row->longitud?>" onKeyUp="calcular_cubicaje(this)"></td>
    <td class="text-right"><input class="form-control form-control-sm text-right" name="volumen_m3[]" value="<?php echo ($row->volumen_m3!=0)? number_format($row->volumen_m3,2):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="volumen_pies[]" value="<?php echo ($row->volumen_pies!=0)? number_format($row->volumen_pies,2):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="volumen_total_m3[]" value="<?php echo ($row->volumen_total_m3!=0)? number_format($row->volumen_total_m3,2):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="volumen_total_pies[]" value="<?php echo ($row->volumen_total_pies!=0)? number_format($row->volumen_total_pies,2):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="precio_unitario[]" value="<?php echo ($row->precio_unitario!=0)? number_format($row->precio_unitario,2):""?>" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm text-right" name="precio_total[]" value="<?php echo ($row->precio_total!=0)? number_format($row->precio_total,2):""?>" readonly="readonly"></td>
</tr>
<?php
	$cantidad++;
	}
}
?>
</tbody>
<tfoot>
	<tr>
		<th class="text-center"></th>
		<th class="text-center"><?php echo count($cubicaje)?></th>
		<th colspan="5"></th>
		<th class="text-right" style="padding-right:12px"><?php echo number_format($volumen_pies,2)?></th>
		<th class="text-right" style="padding-right:12px"><?php echo number_format($volumen_total_m3,2)?></th>
		<th class="text-right" style="padding-right:12px"><?php echo number_format($volumen_total_pies,2)?></th>
		<th></th>
		<th class="text-right" style="padding-right:12px"><?php echo number_format($precio_total,2)?></th>
	</tr>
</tfoot>
</table>
