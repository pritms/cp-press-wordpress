<div class="modal-dialog">
	<p class="validateTips">Select item to insert in this portfolio.</p>
 
	<form>
		<fieldset>
			<select name="select_item" id="select_item" class="select widefat ui-widget-content ui-corner-all">
			<? foreach($post_types as $post_type): 
				foreach($post_type['posts'] as $id => $post):
			?>
				<option value="<?= $post_type['name'].'-'.$id; ?>"><?= $post_type['label'].' --> '.$post  ?></option>
			<?	endforeach;
				endforeach;
			?>
			</select>
		</fieldset>
	</form>
</div><!-- /.modal-dialog -->
