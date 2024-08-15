<html>
<head>
	<title></title>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<style type="text/css">body {
 font-size:11px;
 font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif, "Geeza Pro", "Nadeem", "Al Bayan", "DecoType Naskh", "DejaVu Serif", "STFangsong", "STHeiti", "STKaiti", "STSong", "AB AlBayan", "AB Geeza", "AB Kufi", "DecoType Naskh", "Aldhabi", "Andalus", "Sakkal Majalla", "Simplified Arabic", "Traditional Arabic", "Arabic Typesetting", "Urdu Typesetting", "Droid Naskh", "Droid Kufi", "Roboto", "Tahoma", "Times New Roman", "Arial", serif , "adobe arabic"
 ;
}
@page { margin: 0px; }
body { margin: 0px; }
@media print {
    html, body {
        height: 99%;    
    }
}
	</style>
</head>
<body style="">
<div style="background-color:#fff;position:relative;width:750px;height:auto;margin:0 auto;border: 1px solid #000000;overflow: hidden;min-height:1000px;padding-bottom:5px;"><img src="{{ $payment->application->institute->letterhead }}" style="width:750px;height:1000px;margin:0 auto;" />
<div style="display:block;width:650px;position:absolute;margin:20px 10px 5px 50px;height: auto;min-height:1000px;     top: 0px;left:0;z-index:1;">
<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;border-bottom: 0px solid #cc0000;">
	<tbody>
		<tr>
			<td style="vertical-align:middle;width: 50%;text-align:left;">
			<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.5;font-size:13px;font-style:italic;"><br />
			<br />
			&nbsp;</p>
			</td>
		</tr>
	</tbody>
</table>
<br><br><br><br><br>
<p align="center">
    <button onclick="history.back()">Go Back</button>
<button onclick="window.print()">Print Receipt</button></p>

<p align="center"><span style="font-size:18px;"><strong>FEES RECEIPT</strong></span></p>

<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
	<tbody>
		<tr>
			<td style="vertical-align:middle;width: 30%;text-align:left;">
			<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">REF: TOPUP{{ $payment->application->student->id }}-{{ $payment->application->id }}</p>
			</td>
			<td style="vertical-align:middle;width: 30%;text-align:right;">
			<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">{{ $payment->application->status }} on {{ $payment->application->updated_at }}</p>
			</td>
		</tr>
	</tbody>
</table>

<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
	<tbody>
		<tr>
			<td style="vertical-align:middle;width: 70%;text-align:left;font-style:italic;">
			<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">To</p>

			<p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Applicant Name:</b> {{ $payment->application->student->name }}</p>

			<p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Email Address:</b> {{ $payment->application->student->email }} <b>Mobile Number:</b> {{ $payment->application->student->phone }}</p>
			</td>
			<td style="vertical-align:middle;width: 30%;text-align:right;"><img height="90px" src="{{ $payment->application->student->avatar }}" style="height:90px" /></td>
		</tr>
	</tbody>
</table>

<table border="1" cellpadding="1" cellspacing="1" style="width:100%;">
	<tbody>
		<tr>
			<td>DATE</td>
			<td>APPLICATION ID</td>
			<td>INSTITUTE</td>
			<td>COURSE</td>
			<td>PAYMENT REFERENCE</td>
			<td>AMOUNT</td>
		</tr>
		<tr>
			<td>{{ $payment->created_at }}</td>
			<td>{{ $payment->application->id }}</td>
			<td>{{ $payment->application->institute->title }}</td>
			<td>{{ $payment->application->course->title }}</td>
			<td>{{ $payment->reference }}</td>
			<td>NGN {{ $payment->amount }}</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>

<p>&nbsp;</p>

<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
	<tbody>
		<tr>
			<td style="vertical-align:middle;width: 100%;text-align:left;">
			<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:5px;text-align:left;">&nbsp;</p>

			<p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:center;"><b>
If you have further queries feel free to reach out to us via email at {{ $payment->application->institute->officeremail }} or contact us through direct whatsapp or phone call at {{ $payment->application->institute->phone }}</b></p>
			&nbsp;

			<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
				<tbody>
					<tr>
						<td style="vertical-align:middle;width: 100%;text-align:left;">
						<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;line-height:1.2;font-size:10px;font-weight:normal;">
							<tbody>
								<tr>
									<td style="vertical-align:top;width: 30%;text-align:left;">&nbsp;</td>
									<td style="vertical-align:top;width: 70%;text-align:right;">
									<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;line-height:1.2;font-size:10px;font-weight:normal;font-style:italic;">
										<tbody>
											<tr>
												<td style="vertical-align:top;width: 40%;text-align:right;"><img height="80px;" src="{{ $payment->application->institute->seal }}" /></td>
												<td style="vertical-align:top;width: 60%;text-align:right;">
												<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">For and on behalf of {{ $payment->application->institute->title }}</p>
												<img height="35px;" src="{{ $payment->application->institute->signature }} " />
												<p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">{{ $payment->application->institute->officername }}<br />
												Admission Officer<br />
												{{ $payment->application->institute->officeremail }}</p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>

			<p style="page-break-before: always">&nbsp;</p>
			</td>
		</tr>
	</tbody>
</table>
</div>
</div>
</body>
</html>
