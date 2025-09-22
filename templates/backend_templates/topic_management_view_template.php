<div class="backend_wrapper">

<div class="content_container_wrapper">
<span class="primary">Display of the topic</span>
<div class="content_container_margin_bottom">
<?php $i = 1; ?>
<?php foreach ($rows as $row) { ?>
<ul>
<li class="li_un"><?php echo sanitize($row['topic_title']);?></li>
<li class="li_un"><a class="link_secondary" href="index.php?section=profile&id=<?php echo sanitize($row['user_id']);?>"><?php echo sanitize_ucfirst($row['username']);?></a></li>
<li class="li_un"><?php echo sanitize($row['post_created']);?></li>
<li class="li_un"><?php echo sanitize($row['post_content']);?></li>
</ul>
<?php $i++; ?>
<?php } ?>
</div>
</div>
</div>
