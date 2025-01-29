
<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;
$n = 0;

$tot_reg = count($proforma);

//print_r ($valorizacion); exit();

foreach($proforma as $key=>$row):

	/*
	$id_tipo_afectacion = $row->id_tipo_afectacion;

	$n++;
	$monto = $row->monto;

	if($id_tipo_afectacion=='30'){
		$stotal =str_replace(",","",number_format($monto));
		$igv_   = 0;
	
	}else{
		$stotal = str_replace(",","",number_format($monto/1.18,1));
		$igv_   = str_replace(",","",number_format($stotal * 0.18,1));	
	}

	$disabled = "";
	if($tot_reg!=$n) {

		$disabled = "disabled";
	}
	*/
	$n++;
	
		
?>

<tr style="font-size:13px" data-toggle="tooltip" data-placement="top" title="<?php echo $row->id_producto ?>"  >	
	
	<td class="text-center" style="font-size:8.0pt"><?php echo $n?>
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_producto]" value="<?php echo $row->id_producto?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][codigo_producto]" value="<?php echo $row->codigo?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_descuento]" value="<?php echo $row->id_descuento?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][precio_unitario]" value="<?php echo $row->precio_unitario?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][sub_total]" value="<?php echo $row->sub_total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_unidad_medida]" value="<?php echo $row->id_unidad_medida?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][valor_venta_bruto]" value="<?php echo $row->valor_venta_bruto?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][item]" value="<?php echo $n?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][fecha]" value="<?php echo $row->fecha?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][denominacion]" value="<?php echo $row->denominacion?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][monto]" value="<?php echo $row->total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][pu]" value="<?php echo $row->precio_unitario?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][igv]" value="<?php echo $row->igv?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][pv]" value="<?php echo $row->precio_venta?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][vv]" value="<?php echo $row->valor_venta?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][total]" value="<?php echo $row->total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][abreviatura]" value="<?php echo $row->codigo?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][cantidad]" value="<?php echo $row->cantidad?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][descuento]" value="<?php echo $row->descuento?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][cod_contable]" value="000" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][descripcion]" value="<?php echo $row->producto_prof?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][vencio]" value="" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_concepto]" value="0" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_tipo_afectacion]" value="0" />
    </td>

	<td class="text-center" style="font-size:8.0pt"><?php echo $row->producto_prof?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->cantidad?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->valor_venta_bruto?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->descuento?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->valor_venta_bruto?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->igv?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->total?></td>
	<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i></button></td>;
	

</tr>

<?php 
	$total += $row->total;
	//$total += $total;
	//$stotal += $stotal;
	//$igv_ += $igv_;

/*
	total_productos = Number(total_productos) + Number(precio_venta)*Number(cantidad);
	total_descuento = Number(total_descuento) + Number(descuento);
	total_pagar = Number(total_pagar) + Number(total);

	sub_total =  Number(sub_total) + Number(valor_venta);
	total_igv = Number(total_igv) + Number(igv);

	
	$('#deudaTotales').val(Number(total_productos).toFixed(2));

	$('#totalDescuento').val(Number(total_descuento).toFixed(2));
	$('#total').val(Number(total_pagar).toFixed(2));

	$('#stotal').val(Number(sub_total).toFixed(2));
	$('#igv').val(Number(total_igv).toFixed(2));
*/


endforeach;
?>

<tr>
	<input type="hidden" name="deudaTotal_pf" id="deudaTotal_pf" value="<?php echo number_format($total,2)?>" />	
</tr>


