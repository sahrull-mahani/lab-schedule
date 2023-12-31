<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>

	<style>
		body {
			font-family: 'Inter', sans-serif;
			height: 100vh;
		}

		.search {
			animation: search 4s infinite;
		}

		@keyframes search {
			25% {
				top: 30px;
			}

			50% {
				left: 110px;
				transform: rotate(-80deg);
			}
		}

		.container {
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			position: relative;
			height: 99%;
		}

		.container-content {
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
		}

		.container-content p {
			font-size: 80px;
			font-weight: 800;
			margin: 0 10px;
		}

		.container-content span {
			font-size: 70px;
		}

		.container-content .search {
			position: absolute;
			left: 60px;
			top: 26px;
			font-size: 50px;
		}
		a {
			text-decoration: none;
			color: green;
			font-weight: lighter;
			transition: all .3s ease-in;
		}
		a:hover {
			font-weight: bold;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="container-content">
			<p class="mr-4">4</p>
			<span>😔</span>
			<div class="search">
				🔎
			</div>
			<p class="ml-4">4</p>
		</div>
		<p class="text-2xl">Page not found. <a href="/">beranda</a></p>
	</div>
</body>

</html>