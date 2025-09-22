
<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;
$n = 0;



$ValorUnitario_ = 0;
$ValorVB_ = 0;
$ValorVenta_ = 0;
$Igv_ = 0;
$Total_ = 0;
$tasa_igv_=0.18;
$Cantidad_=1;
$Descuento_ = 0;

$tot_reg = count($orden_compra);

//print_r ($valorizacion); exit();

//print_r ($id_afectacion_sede); //exit();

$id_tipo_afectacion = $id_afectacion_sede;

//print_r ($id_tipo_afectacion);

foreach($orden_compra as $key=>$row):
	//$id_tipo_afectacion = $row->id_tipo_afectacion;
	$n++;
	$monto = $row->total; //$row->monto;
	$PrecioVenta_= $row->precio_venta; //$row->valor_unitario;
	$Descuento_  = $row->descuento; //$row->descuento_porcentaje;
	$Cantidad_ = $row->cantidad;
	
	if ($id_tipo_afectacion == '20') {
		//$stotal = str_replace(",", "", number_format($monto));
		$igv_   = 0;

		$ValorUnitario_ = str_replace(",", "", number_format($PrecioVenta_,  2));
		$ValorVB_ = str_replace(",", "", number_format($ValorUnitario_ * $Cantidad_, 2));
		$ValorVenta_ = str_replace(",", "", number_format($ValorVB_ - $Descuento_, 2));
		$Igv_ = 0;		
		$Total_ = str_replace(",", "", number_format($ValorVenta_ + $Igv_, 2));

		$stotal = $Total_;

	} else {

		$ValorUnitario_ = $PrecioVenta_ /(1+$tasa_igv_);
		$ValorVB_ = $ValorUnitario_ * $Cantidad_;
		$ValorVenta_ = $ValorVB_ - $Descuento_;
		$Igv_ = $ValorVenta_ * $tasa_igv_;		
		$Total_ = $ValorVenta_ + $Igv_;	
		
		$ValorUnitario_ = str_replace(",", "", number_format($ValorUnitario_, 2));
		$ValorVB_ = str_replace(",", "", number_format($ValorVB_, 2));
		$ValorVenta_ = str_replace(",", "", number_format($ValorVenta_, 2));
		$Igv_ = str_replace(",", "", number_format($Igv_, 2));		
		$Total_ = str_replace(",", "", number_format($Total_, 2));
		
		$stotal = $Total_;
		$igv_   = $Igv_;

	}
	
		
?>

<tr style="font-size:13px" data-toggle="tooltip" data-placement="top" title="<?php echo $row->id_producto ?>"  >	
	
	<td class="text-center" style="font-size:8.0pt"><?php echo $n?>
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_producto]" value="<?php echo $row->id_producto?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][codigo_producto]" value="<?php echo $row->codigo?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_descuento]" value="<?php echo $row->id_descuento?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][precio_unitario]" value="<?php $ValorUnitario_//echo $row->precio_unitario?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][sub_total]" value="<?php echo $ValorVenta_//$row->sub_total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_unidad_medida]" value="<?php echo $row->id_unidad_medida?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][valor_venta_bruto]" value="<?php echo $ValorVB_//$row->valor_venta_bruto?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][item]" value="<?php echo $n?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][fecha]" value="<?php echo $row->fecha?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][denominacion]" value="<?php echo $row->denominacion?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][monto]" value="<?php echo $Total_//$row->total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][pu]" value="<?php echo $ValorUnitario_//$row->precio_unitario?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][igv]" value="<?php echo $Igv_//$row->igv?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][pv]" value="<?php echo  $PrecioVenta_//$row->precio_venta?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][vv]" value="<?php echo $ValorVenta_//$row->valor_venta?>" />			
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][total]" value="<?php echo $Total_//$row->total?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][abreviatura]" value="<?php echo $row->abreviatura?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][cantidad]" value="<?php echo $row->cantidad?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][descuento]" value="<?php echo $row->descuento?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][cod_contable]" value="000" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][descripcion]" value="<?php echo $row->producto_prof?>" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][vencio]" value="" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_concepto]" value="0" />
			<input type="hidden" name="valorizacion_detalle[<?php echo $key?>][id_tipo_afectacion]" value="0" />
    </td>

	<td class="text-left" style="font-size:8.0pt"><?php echo $row->codigo?></td>
	<td class="text-left" style="font-size:8.0pt"><?php echo $row->producto_prof?></td>
	<td class="text-center" style="font-size:8.0pt"><?php echo $row->cantidad?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $PrecioVenta_//$row->valor_venta_bruto?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $row->descuento?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $ValorVenta_//$row->valor_venta_bruto?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $Igv_//$row->igv?></td>
	<td class="text-right" style="font-size:8.0pt"><?php echo $Total_//$row->total?></td>
	<!--
	<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i></button></td>;
-->

</tr>

<?php 
	$total += $Total_; //$row->total;
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


