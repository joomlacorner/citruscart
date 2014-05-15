<?php 
/*------------------------------------------------------------------------
# com_citruscart - citruscart
# ------------------------------------------------------------------------
# author    Citruscart Team - Citruscart http://www.citruscart.com
# copyright Copyright (C) 2014 - 2019 Citruscart.com All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://citruscart.com
# Technical Support:  Forum - http://citruscart.com/forum/index.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'citruscart.js', 'media/citruscart/js/'); ?>
<?php $state = $this->state; ?>
<?php $form = $this->form; ?>
<?php $items = $this->items; ?>
<?php $row = $this->row; ?>

<h1 style="margin-left: 2%; margin-top: 2%;"><?php echo JText::_('COM_CITRUSCART_SELECT_PRODUCTS_FOR'); ?>: <?php echo $row->coupon_name; ?></h1>

<form action="<?php echo JRoute::_( $form['action'] )?>" method="post" name="adminForm" enctype="multipart/form-data">
<div class="note_green" style="width: 96%; text-align: center; margin-left: auto; margin-right: auto;">
    <?php echo JText::_('COM_CITRUSCART_FOR_CHECKED_ITEMS'); ?>:
    <button class="btn btn-success" onclick="document.getElementById('task').value='selected_switch'; document.adminForm.submit();"> <?php echo JText::_('COM_CITRUSCART_CHANGE_STATUS'); ?></button>

    <table>
        <tr>
            <td align="left" width="100%">
                <input name="filter" value="<?php echo $state->filter; ?>" />
                <button class="btn btn-primary" onclick="this.form.submit();"><?php echo JText::_('COM_CITRUSCART_SEARCH'); ?></button>
                <button class="btn btn-danger" onclick="CitruscartFormReset(this.form);"><?php echo JText::_('COM_CITRUSCART_RESET'); ?></button>
            </td>
            <td nowrap="nowrap">
                <?php $attribs = array('class' => 'inputbox', 'size' => '1', 'onchange' => 'document.adminForm.submit();'); ?>
                <?php echo CitruscartSelect::category( $state->filter_category, 'filter_category', $attribs, 'filter_category', true, true ); ?>
            </td>
        </tr>
    </table>

	<table class="table table-striped table-bordered" style="clear: both;">
		<thead>
            <tr>
                <th style="width: 5px;">
                	<?php echo JText::_('COM_CITRUSCART_NUM'); ?>
                </th>
                <th style="width: 20px;">
                	<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $items ); ?>);" />
                </th>
                <th style="width: 50px;">
                	<?php echo CitruscartGrid::sort( 'COM_CITRUSCART_ID', "tbl.product_id", $state->direction, $state->order ); ?>
                </th>                
                <th style="text-align: left;">
                	<?php echo CitruscartGrid::sort( 'COM_CITRUSCART_NAME', "tbl.product_name", $state->direction, $state->order ); ?>
                </th>
                <th>
	                <?php echo JText::_('COM_CITRUSCART_STATUS'); ?>
                </th>
            </tr>
		</thead>
        <tbody>
		<?php $i=0; $k=0; ?>
        <?php foreach ($items as $item) : ?>
            <tr class='row<?php echo $k; ?>'>
				<td align="center">
					<?php echo $i + 1; ?>
				</td>
				<td style="text-align: center;">
					<?php echo CitruscartGrid::checkedout( $item, $i, 'product_id' ); ?>
				</td>
				<td style="text-align: center;">
					<?php echo $item->product_id; ?>
				</td>	
				<td style="text-align: left;">
					<?php echo $item->product_name; ?>
				</td>
				<td style="text-align: center;">
					<?php 
					Citruscart::load('CitruscartTableProductCoupons', 'tables.productcoupons');
					$table = JTable::getInstance('ProductCoupons', 'CitruscartTable');
                    $keynames = array();
                    $keynames['product_id'] = $item->product_id;
                    $keynames['coupon_id'] = $row->coupon_id;
					?>
					<?php $table->load( $keynames ); ?>
					<?php echo CitruscartGrid::enable(isset($table->product_id), $i, 'selected_'); ?>
				</td>
			</tr>
			<?php $i=$i+1; $k = (1 - $k); ?>
			<?php endforeach; ?>
			
			<?php if (!count($items)) : ?>
			<tr>
				<td colspan="10" align="center">
					<?php echo JText::_('COM_CITRUSCART_NO_ITEMS_FOUND'); ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="20">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<input type="hidden" name="task" id="task" value="selectproducts" />
	<input type="hidden" name="boxchecked" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $state->order; ?>" />
	<input type="hidden" name="filter_direction" value="<?php echo $state->direction; ?>" />
	
	<?php echo $this->form['validate']; ?>
</div>
</form>