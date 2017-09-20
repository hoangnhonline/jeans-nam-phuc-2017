<?php if( $tagArr->count() > 0): ?>
	<?php foreach( $tagArr as $value ): ?>
	<option value="<?php echo e($value->id); ?>" <?php echo e(($tagSelected) && in_array($value->id, $tagSelected) ? "selected" : ""); ?>><?php echo e($value->name); ?></option>
	<?php endforeach; ?>
<?php endif; ?>