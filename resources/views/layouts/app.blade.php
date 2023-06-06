<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="admin, dashboard">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dompet : Payment Admin Template">
	<meta property="og:title" content="Dompet : Payment Admin Template">
	<meta property="og:description" content="Dompet : Payment Admin Template">
	<meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">

	<!-- PAGE TITLE HERE -->
	<title>Dashboard</title>

	<!-- FAVICONS ICON -->
	{{-- <link rel="shortcut icon" type="image/png" href="images/favicon.png"> --}}

	{{-- <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">

    <link href="css/style.css" rel="stylesheet"> --}}
	<!-- Style css -->
    @include('includes.styles')
</head>

<body>
    <div id="main-wrapper" class="show">

        @include('includes.header')

        @include('includes.sidebar')

        @yield('content')





    </div>

    @include('includes.footer')
    @include('includes.scripts')
	<script>
		jQuery(document).ready(function(){
			setTimeout(function() {
				dezSettingsOptions.version = 'dark';
				new dezSettings(dezSettingsOptions);
			},500)
		});
	</script>
</body>
</html>
