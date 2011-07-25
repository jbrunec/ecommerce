<?php  //debug($totalPrice);?>
<?php 
	debug($cartContents);
	//echo date("m/d/y",time());
	$i = 0;
	
	echo $html->addCrumb('Your cart contents', array('controller' => 'carts', 'action' => 'view/c:'.$c));
	
	echo $form->create('Cart', array('controller' => 'carts', 'action' => 'view'));
?>

<table id="gradient-style" summary="Meeting Results">
    <thead>
    	<tr>
    		<th scope="col">&nbsp;</th>
        	<th scope="col">Item:</th>
            <th scope="col">Price:</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total:</th>
        </tr>
    </thead>
    
    <tbody>
    <?php 
    if(empty($cartContents)){?>
		<tr>
			<td colspan="5">The Cart is empty!!!! Go Grab Something!</td>
		</tr>	
	<?php }else{ ?>
    <?php foreach ($cartContents as $item):
    	//$totalPrice += ($item['Product']['pd_price'] * $item['Cart']['ct_qty']);
    ?>
    	<?php echo $form->input("Cart.".$i.".id", array('value' => $item['Cart']['id'], 'type' => 'hidden'));?>
    	<tr>
        	<td><?php echo $html->image('products/'.$item['Product']['pd_image'], array('width' => '50', 'height' => '50'));?></td>
            <td><?php echo $item['Product']['pd_name'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['Product']['pd_price'];?></td>
            <td><?php echo $form->input('Cart.'.$i.'.ct_qty',array('label' => 'X ','value' => $item['Cart']['ct_qty']));?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['Cart']['ct_qty'] * $item['Product']['pd_price'];?></td>
            <td><?php echo $html->link('Remove Item', "/carts/emptyCart/c:$c/ct:".$item['Cart']['id']);?></td>
        </tr>
        <?php $i++;?>
    <?php endforeach;?>
    <?php }?>
    </tbody>
    <tfoot>
    	<?php $result = $this->requestAction('/carts/isCartEmpty');?>
    	<tr>
        	<td colspan="2">&nbsp;</td>
        	<td colspan="1"><?php echo $html->link('Continue shopping', '/carts/index/c:'.$c)?></td>
        	<?php if(!$result){?>
        		<td colspan="1"><?php echo $html->link('Checkout',"/orders/index/c:$c/step:1");?></td>
        	<?php } ?>
        	<td colspan="1"><?php echo '= '.Configure::read('Shop.currency').' '.$totalPrice;?></td>
        	<td colspan="1"><?php echo $form->end('Update Cart');?></td>
        </tr>
        
        	

    </tfoot>
</table>