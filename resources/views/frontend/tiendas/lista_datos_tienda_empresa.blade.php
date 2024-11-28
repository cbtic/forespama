<?php 

foreach($tienda_empresa_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id?></td>
	<td class="text-left"><?php echo $row->denominacion?></td>
</tr>
<?php
endforeach;
?>

