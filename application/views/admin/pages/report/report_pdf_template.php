<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tes</title>
    <style>
         #container {
            width:18.5cm;height:26.7cm;
            margin: auto;
        }
        p{
            line-height: 150%;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
        }
        td{
            text-align: center;
        }
        #table-ket{
            margin-top: 0.5cm;
        }
        tr[section="signature-sec"] td,tr[section="rekening-sec"] td,tr[section="catatan"] td{
            padding-top: 0.5cm;
        }

        .signature{
            height:2cm;width:100%;
        }
        #rekening{
            width: 100%;
            padding: 10px;
            background-color: #E9E9E9;
        }
        #penerima{
            border:solid 1px black; padding: 0 5px; border-radius:5px;
        }
        .header{
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div id="container">
        <h4 class="text-center header"><?php echo strtoupper($filename) ?></h4>
        <table border="1" cellpadding="2" cellspacing="0" style="margin:auto;">
            <thead>
              <tr>
                <th>No</th>
                <th>Receive Time</th>
                <th>Invoice Number</th>
                <th>Ref Code</th>
                <th>Trx Value</th>
                <th>Tahapan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php $trx_total = 0; ?>
                <?php $trx_charge = 0; ?>
                <?php foreach($reports as $report):
                    $tahapan = '';
                    $stat = '';

                      if($report['LASTSTATE'] == 1){
                          $tahapan = "Incomplete";
                      }else{
                          $tahapan = "Complete";
                      }

                      if($report['LASTRC'] == 0){
                          $stat = "Success";
                      }else{
                          $stat = "Failed";
                      }
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $report['RCVTIME']; ?></td>
                        <td><?php echo $report['INVOICENO']; ?></td>
                        <td><?php echo $report['REFNO']; ?></td>
                        <td><?php echo $report['TRXVALUE']; ?></td>
                        <td><?php echo $tahapan; ?></td>
                        <td><?php echo $stat; ?></td>
                        <!-- <td><?php echo $report['TRFCHARGES']; ?></td> -->
                    </tr>
                    <?php $no++; ?>
                    <?php $trx_total += $report['TRXVALUE']; ?>
                    <!-- <?php $trx_charge += $report['TRFCHARGES']; ?> -->
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">Total</td>
                    <td><?php echo $trx_total; ?></td>
                    <td> &nbsp; </td>
                    <td> &nbsp; </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
