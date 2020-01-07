<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="hoffmandev@outlook.com">
<meta name="author" content="Thyago Hoffman">
<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
<title><?php echo "{$title}"; ?></title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicons -->
<link rel="icon" href="<?php echo base_url('assets/images/favicon.png') ?>" />
<link rel="apple-touch-icon" href="<?php echo base_url('assets/images/apple-touch-icon.png') ?>" />

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/vendors/bootstrap/css/bootstrap.min.css') ?>" />
<!--external css-->
<link rel="stylesheet" href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.css') ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/zabuto_calendar.css') ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/vendors/gritter/css/jquery.gritter.css') ?>" type="text/css" />

<!-- Custom styles for this template -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/style-responsive.css') ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>" />

<link href="<?php echo base_url('assets/lib/iziToast-master/dist/css/iziToast.min.css') ?>" rel="stylesheet" />

<script src="<?php echo base_url('assets/vendors/chart-master/Chart.js') ?>"></script>

<?php

if ( !empty($header)) {
	foreach ($header as $header) {
		echo "<link rel='stylesheet' href='{$header}' />";
	}
}
?>
