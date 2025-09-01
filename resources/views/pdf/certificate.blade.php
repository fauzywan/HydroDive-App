<!DOCTYPE html>
<html>
<head>
    <title>Certificate</title>
    <style>
        body { text-align: center; font-family: sans-serif; }
        .title { font-size: 24px; font-weight: bold; margin-top: 100px; }
        .subtitle { font-size: 18px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="title">Certificate of Membership</div>
    <div class="subtitle">This is to certify that</div>
    <h1>{{ $club->name }}</h1>
    <div class="subtitle">is officially part of Akuatik Indonesia</div>
    <p style="margin-top: 50px;">Issued on {{ now()->format('F d, Y') }}</p>
</body>
</html>
