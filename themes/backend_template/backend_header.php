<!DOCTYPE html>
<html lang="de">
<head>
<title><?php echo sanitize(name); ?></title>
<meta charset="utf-8">
<meta name="robots" content="INDEX,FOLLOW">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="pathologicalplay">
<meta name="revisit-after" content="2 days">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="themes/backend_template/backend.css" media="all" type="text/css">
</head>
<body>
<div class="backend_template_row">
<div class="backend_template_column_1">
<span class="primary"><?php echo sanitize(name); ?> <?php echo sanitize(version); ?></span>
<div class="backend_template_nav">
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="index.php?section=setting_management">Settings</a></li>
<li><a href="index.php?section=user_management">Manage users</a></li>
<li><a href="index.php?section=forum_management">Manage forums</a></li>
<li><a href="index.php?section=category_management">Manage categories</a></li>
<li><a href="index.php?section=view_activity_log">Activity log</a></li>
<li><a href="index.php?section=topic_management">Manage topics</a></li>
<li><a href="index.php?section=post_management">Manage posts</a></li>
</ul>
</div>
</div>
<div class="backend_template_column_2">
<main>
