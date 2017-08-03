<!DOCTYPE html>
<html>
	<head>
		<meta charset="ISO-8859-1">
		<title>Transaksi Pembelian Voucher Wifi.id</title>
	</head>
	<body>
		<div class="email-wrapper" style="background: #FFFFFF;">
			
			<div class="email-header" style="padding: 10px; text-align: center; background-image: url('https://prodapi-app.tmoney.co.id/barrel/images/header.png'); background-size: 100% 100%; height: 50px; border-bottom: 3px solid #EF4C4D;">
				<img src="https://prodapi-app.tmoney.co.id/barrel/images/logo.png" style="max-height: 100% !important; width: auto; display: inline-block;" />
			</div>
			
			<div class="email-header-thanks" style="text-align: center;">
				<p><strong>Hello <?php echo $CUSTNAME ?>,</strong></p>
				<p>Terima kasih Anda telah bertransaksi menggunakan <strong>tmoney online</strong>.</p>
				<p>Berikut detil transaksi yang telah Anda lakukan:</p>
			</div>
			
			<div class="email-proof" style="margin: 10px 25px;">
				<div class="email-proof-header" style="background: #EF4C4D; padding: 15px 20px; color: #FFFFFF;">
					<strong>Hasil Transaksi</strong>
				</div>
				<div class="email-proof-body" style="background-image: url('https://prodapi-app.tmoney.co.id/barrel/images/background.png'); background-size: 100% 100%; padding: 15px 20px;">
					<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td width="30%">Jenis Transaksi</td>
				<td width="70%">: PEMBELIAN VOUCHER <a href="http://wifi.id">WIFI.ID</a></td>
			</tr>
			<tr>
				<td>Nomor Transaksi</td>
				<td>: <?php echo $SYSLOGNO ?></td>
			</tr>
			<tr>
				<td>Institusi</td>
				<td>: <a href="http://wifi.id">WIFI.ID</a></td>
			</tr>
			<tr>
				<td>Produk</td>
				<td>: Voucher <a href="http://wifi.id">WIFI.ID</a> </td>
			</tr>
			<tr>
				<td>Nominal</td>
				<td>: <?php echo $TRXVALUE ?></td>
			</tr>
			<tr>
				<td>Fee</td>
				<td>: <?php echo $TRFCHARGES ?></td>
			</tr>
			<tr>
				<td>Total Transaksi</td>
				<td>: <?php echo $TRXVALUE + $TRFCHARGES ?></td>
			</tr>
			<tr>
				<td>Waktu Transaksi</td>
				<td>: <?php echo $RCVTIME ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>: Berhasil</td>
			</tr>
			<tr>
				<td>Deskripsi</td>
				<td>: <?php echo $TRXDESC ?></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>: Informasi lebih lanjut silakan hubungi <strong>Call Center WIFI.ID (021) 500705</strong> </td>
			</tr>
					</table>
				</div>
			</div>
			
			<div class="email-footer-thanks" style="background: #808080; text-align: center; color: #FFFFFF; font-weight: bold; font-size: larger; margin: 20px 0 0 0; padding: 1px 0;">
				<p>Terima kasih! Salam, tmoney</p>
			</div>
			
			<div class="email-footer" style="background-image: url('https://prodapi-app.tmoney.co.id/barrel/images/footer.png'); background-size: 100% 100%; padding: 10px 0; text-align: center;">
				<p><strong>Customer Care</strong></p>
				<p style="color: #000000; text-decoration: none;"><img src="https://prodapi-app.tmoney.co.id/barrel/images/telephone.png" style="vertical-align: middle; width: 25px; height: 25px; margin: 0 5px;"/> (021) 380 8888</p>
				<p style="color: #000000; text-decoration: none;"><img src="https://prodapi-app.tmoney.co.id/barrel/images/email.png"  style="vertical-align: middle; width: 25px; height: 25px; margin: 0 5px;"/> customerservice@tmoney.co.id</p>
			</div>
			
		</div>
	</body>
</html>