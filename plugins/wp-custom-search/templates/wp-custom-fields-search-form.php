<?php if($title && !(@$params['noTitle'])){
	echo $params['before_title'].$title.$params['after_title'];
}?>
	<form method='get' class='<?php echo $formCssClass?>' action='<?php echo $formAction?>'>
		<?php echo $hidden ?>
		<div class="search-bar">
			<ul>
				<?php
				
					foreach($inputs as $input){?>
				<?php echo $input->getInput()?>
				<?php	}?>
	
				<li><input type='submit' name='search' class="search-btn" value=''/></li>
			</ul>
		</div>
	</form>
