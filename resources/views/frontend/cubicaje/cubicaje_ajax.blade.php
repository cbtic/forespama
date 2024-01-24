<?php 
if($cubicaje):
foreach($cubicaje as $row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top">
	<td class="text-center"><?php echo $row->id?></td>
	<td class="text-center"><input class="form-control form-control-sm" name="diametro_1" onKeyUp="calcular_cubicaje(this)"></td>
	<td class="text-center"><input class="form-control form-control-sm" name="diametro_2" onKeyUp="calcular_cubicaje(this)"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="diametro_dm" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="longitud" onKeyUp="calcular_cubicaje(this)"></td>
    <td class="text-right"><input class="form-control form-control-sm" name="volumen_m3" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="volumen_pies" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="volumen_total_m3" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="volumen_total_pies" readonly="readonly"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="precio_unitario"></td>
	<td class="text-right"><input class="form-control form-control-sm" name="precio_total" readonly="readonly"></td>
</tr>
<?php
endforeach;
endif;
?>
