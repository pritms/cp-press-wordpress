<div class="modal-dialog">
	<p class="validateTips">Insert Youtube Video url.</p>
 
	<form id="add_video_form">
		<fieldset>
			<input type='text' name='video_url' id="video_url" data-validation="custom" data-validation-regexp="^https?:\/\/www.(youtube.com)" data-validation-error-msg="You did not enter a valid URL" class="select widefat ui-widget-content ui-corner-all" />
			<div id="video_details" style="display: none;">
				<p>
					<label>Title </label><input type='text' name='video_title' id="video_title" class="select widefat ui-widget-content ui-corner-all" value=''/>
				</p>
				<p>
					<label>Thumbnail </label>
					<input type='hidden' name='video_thumbnail' id="video_thumbnail" value=''/><br />
					<img id="video_thumbnail_img" src="" />
				</p>
			</div>
		</fieldset>
	</form>
</div><!-- /.modal-dialog -->