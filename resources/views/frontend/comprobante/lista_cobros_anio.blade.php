<?php 

foreach($reporte_ventas as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo number_format($row->enero, 2)?></td>
	<td class="text-left"><?php echo number_format($row->febrero, 2)?></td>
	<td class="text-left"><?php echo number_format($row->marzo, 2)?></td>
	<td class="text-left"><?php echo number_format($row->abril, 2)?></td>
	<td class="text-left"><?php echo number_format($row->mayo, 2)?></td>
	<td class="text-left"><?php echo number_format($row->junio, 2)?></td>
	<td class="text-left"><?php echo number_format($row->julio, 2)?></td>
	<td class="text-left"><?php echo number_format($row->agosto, 2)?></td>
	<td class="text-left"><?php echo number_format($row->setiembre, 2)?></td>
	<td class="text-left"><?php echo number_format($row->octubre, 2)?></td>
	<td class="text-left"><?php echo number_format($row->noviembre, 2)?></td>
	<td class="text-left"><?php echo number_format($row->diciembre, 2)?></td>
</tr>
<?php
endforeach;
?>

