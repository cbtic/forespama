<thead>
<tr style="font-size:13px">
	<th>Fecha</th>
	<th>Numero</th>
	<th>Moneda</th>
	<th class="sum">IGV</th>
	<th class="sum">Monto</th>
	<th></th>
	<th></th>
</tr>
</thead>
<tbody>
<?php 
$total = 0;
foreach($proforma as $row){?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" title="<?php echo $row->id?>">
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha))?></td>
    <td class="text-left"><?php echo $row->serie."-".$row->numero?>
	<input type="hidden" class="id" value="<?php echo $row->id?>" />
	</td>
	<td class="text-left"><?php echo $row->moneda;?>
	</td>
	<td class="text-left"><?php echo $row->igv?></td>
	<td class="text-left"><?php echo $row->total?></td>	
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<a href="/comprobante/<?php echo $row->id?>" class="btn btn-sm btn-success" style="font-size:9px!important" target="_blank">
				<i class="fa fa-search" style="font-size:9px!important"></i>
			</a>
		</div>
	</td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<a href="javascript:void(0)" onClick="cargarProformaDet(<?php echo $row->id?>)"class="btn btn-sm btn-info" style="font-size:9px!important" >
				<i class="fa fa-retweet" aria-hidden="true" style="font-size:10px!important"></i>
			</a>

			

		</div>
	</td>

	
</tr>
<?php 	
	$total += $row->total;
	};
?>
</tbody>
<tfoot>
<tr>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Pago Total</th>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="pagoTotal" id="pagoTotal" value="<?php echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">&nbsp;
		
	</td>
</tr>
</tfoot>

<script type="text/javascript">

	function fn_nc_nd(id) {
		//alert("OK");
		//var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';                                
		//html += '<a href="/comprobante/'+id+'" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-paper-plane"></i></a>';
		//return html;
		if (id == "")id = 0;
		var href = '/comprobante/' + id;
		window.open(href, '_blank');

	}
</script>
@push('after-scripts')

<script src="{{ asset('js/ingreso.js') }}"></script>

@endpush