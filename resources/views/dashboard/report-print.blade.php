<html>
<head>
<meta charset="utf-8">
<title>{{ $title }}</title>
<style type="text/css" media="print">
  /* @page {size: auto; margin-bottom: 30px;}
  @media print {
    a[href]:after {content: none !important;}
  } */
</style>
</head>

<body>
  <style> td {padding: 4px} </style>
  <div style="width: 1000px">
    <center>
      @php
        $months = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
      @endphp
      <strong>HASIL LAPORAN BULAN {{strtoupper($months[intval($month)])}} TAHUN {{$year}}</strong>
    </center>
    <br>
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
      <tbody>
        <tr>
          <td align="center">NO.</td>
          <td align="center">Tanggal</td>
          <td align="center">Consultant</td>
          <td align="center">Pendamping</td>
          <td align="center">Tujuan</td>
          <td align="center">Alamat</td>
          <td align="center">Hasil</td>
          <td align="center">Nasabah</td>
          <td align="center">Penawaran</td>
        </tr>
        @php
          $CNC =0;
          $HPR =0;
          $KPR =0;
          $KTP =0;
          $TKO =0;
        @endphp
        @foreach ($reports as $r)
        @php
          $hasil = $r->hasil;
          $$hasil += 1;
          $date = date_create($r->tanggal);
        @endphp
        <tr>
          <td valign="middle" align="center">{{ $loop->iteration }}</td>
          <td valign="middle" align="left">{{date_format($date,"d F Y")}}</td>
          <td valign="middle" align="left">{{ $r->consultant }}</td>
          <td valign="middle" align="left">{{ $r->pendamping }}</td>
          <td valign="middle" align="left">{{ $r->tujuan }}</td>
          <td valign="middle" align="left">{{ $r->alamat }}</td>
          <td valign="middle" align="left">{{ $r->hasil }}</td>
          <td valign="middle" align="left">{{ $r->nasabah }}</td>
          <td valign="middle" align="left">{{ $r->penawaran }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <p><strong>Total :</strong></p>
  <table>
    <tbody>
      <tr>
        <td>CANCEL</td><td>:</td><td>{{$CNC}}</td>
      </tr>
      <tr>
        <td>HOT PROSPEK (HPR)</td><td>:</td><td>{{$HPR}}</td>
      </tr>
      <tr>
        <td>KETEMU PROSPEK (KPR)</td><td>:</td><td>{{$KPR}}</td>
      </tr>
      <tr>
        <td>KETEMU TIDAK PROSPEK (KTP)</td><td>:</td><td>{{$KTP}}</td>
      </tr>
      <tr>
        <td>TIDAK KETEMU ORANG (TKO)</td><td>:</td><td>{{$TKO}}</td>
      </tr>
    </tbody>
  </table>

</body>
</html>