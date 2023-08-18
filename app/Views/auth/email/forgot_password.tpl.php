<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet" />

	<style type="text/css">
		@media screen {
			@font-face {
				font-family: 'Lato';
				font-style: normal;
				font-weight: 400;
				src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
			}

			@font-face {
				font-family: 'Lato';
				font-style: normal;
				font-weight: 700;
				src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
			}

			@font-face {
				font-family: 'Lato';
				font-style: italic;
				font-weight: 400;
				src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
			}

			@font-face {
				font-family: 'Lato';
				font-style: italic;
				font-weight: 700;
				src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
			}
		}

		/* CLIENT-SPECIFIC STYLES */
		body,
		table,
		td,
		a {
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
		}

		table,
		td {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		img {
			-ms-interpolation-mode: bicubic;
		}

		/* RESET STYLES */
		img {
			border: 0;
			height: auto;
			line-height: 100%;
			outline: none;
			text-decoration: none;
		}

		table {
			border-collapse: collapse !important;
		}

		body {
			height: 100% !important;
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
			font-family: "Inter", sans-serif;
		}

		/* iOS BLUE LINKS */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		/* MOBILE STYLES */
		@media screen and (max-width:600px) {
			h1 {
				font-size: 32px !important;
				line-height: 32px !important;
			}
		}

		/* ANDROID CENTER FIX */
		div[style*="margin: 16px 0;"] {
			margin: 0 !important;
		}
	</style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
	<!-- HIDDEN PREHEADER TEXT -->
	<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account. </div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<!-- LOGO -->
		<tr>
			<td bgcolor="#12376c" align="center">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<tr>
						<td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#12376c" align="center" style="padding: 0px 10px 0px 10px;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<tr>
						<td bgcolor="#ffffff" align="center" valign="top" style="padding: 20px 20px 40px 20px; border-top-left-radius: 6px; border-top-right-radius: 6px; ">

							<div class="d-flex" style="background: #f4f4f4; padding: 10px; border-radius: 6px;">
								<img src="https://diskominfo.bolmutkab.go.id/assetsbaru/img/logo%20Bolmut.png" alt="" style="max-width: 37px; margin-right: 5px;">
								<img src="https://www.its.ac.id/wp-content/uploads/2021/10/logo-kominfo-transparent.png" alt="" style="max-width: 45px;">
							</div>


						</td>
					</tr>
				</table>

				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<tr>
						<td bgcolor="#ffffff" align="left" valign="top" style="padding: 0 20px;">
							<h1 style="font-size: 18px; font-weight: 400;">Hi <?= getUserByEmail($identity)->nama_user ?>!</h1>
							<p style="margin: 0; font-size: 16px; line-height: 25px; text-align: justify;">
								Ini adalah email yang dikirim karena kamu menggunakan fitur lupa sandi. Silahkan klik tombol dibawah untuk melanjutkan:</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<!-- <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0; text-align:left">YOUR OPT : *****</p>
                    </td>
                </tr>-->
					<tr>
						<td bgcolor="#ffffff" align="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td bgcolor="#ffffff" align="center" style="padding: 30px">
										<table border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center" style="border-radius: 3px;" bgcolor="#12376c"><a href="<?= site_url("auth/reset_password/$forgottenPasswordCode") ?>" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 55px; border-radius: 6px; display: inline-block;">Reset sandi</a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr> <!-- COPY -->
					<tr>
						<td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; font-size: 16px; font-weight: 400; line-height: 25px; border-bottom-right-radius: 6px; border-bottom-left-radius: 6px;">

							<p style="margin:0 0 20px 0;">Terima Kasih.</p>
							<div class="texbawah" style="text-align: justify;">
								<p style="margin: 0;">Tim Seleksi.</p>
								<p style="margin: 0;">Dinas Komunikasi, Informatika dan Persandian.</p>
								<p style="margin: 0 0 30px 0;">Bolaang Mongondow Utara.</p>
							</div>

							<em style="margin: 0; font-size: 14px; color: #666666;">*Email ini dikirim oleh sistem. Mohon untuk tidak me-reply email ini.</em>
						</td>
					</tr>
					<!-- <tr>
						<td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-size: 18px; font-weight: 400; line-height: 25px;">
							<p style="margin: 0;">Follow me on:</p>
							<div>
								<a style="padding-right:10px" href="https://instagram.com/suraj_vsk"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="25"></a>
								<a href="https://twitter.com/suraj_vsk"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" width="25"></a>
							</div>
						</td>
					</tr> -->
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<tr>
						<td bgcolor="#12376c" align="center" style="padding: 20px; border-radius: 4px 4px 4px 4px; color: #fff; font-size: 18px; font-weight: bold; line-height: 25px;">
							<p style="font-size: 15px; font-weight: 400; color: #fff; margin: 0;">Dinas Komunikasi, Informatika dan Persandian.
							</p>

							<p style="font-size: 15px; font-weight: 400; color: #eee; margin: 0;">Jl. Trans Sulawesi, Boroko, Kec. Kaidipang, Kabupaten Bolaang Mongondow Utara, Sulawesi Utara, Indonesia
							</p>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					<tr>
						<td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-size: 14px; font-weight: 400; line-height: 18px;"> <br>

						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
</body>

</html>