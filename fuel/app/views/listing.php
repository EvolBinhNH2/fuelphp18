<div class="table-responsive col-md-6">
<table class="table table-hover">
	<tr>
		<th>Post Title</th>
		<th>Post Content</th>
		<th>Author Name</th>
		<th>Author Email</th>
		<th>Author Website</th>
		<th></th>
	</tr>
<?php
/**
 * Listing view, views/listing.php
 */

if($posts):
    foreach($posts as $post):
?>
	<tr>
		<td><?php echo $post->post_title; ?></td>
		<td><?php echo $post->post_content; ?></td>
		<td><?php echo $post->author_name; ?></td>
		<td><?php echo $post->author_email; ?></td>
		<td><?php echo $post->author_website; ?></td>
		<td><?php echo \Html::anchor('posts/edit/'.$post->id, '[Edit]');?></td>
	</tr>
<?php
    endforeach;
endif;
?>
</table>
 </div>