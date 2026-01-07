<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
/*        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;700&display=swap');*/
        
        body {
            font-family: 'Noto Sans Khmer', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-size: 12px;
            line-height: 1.2;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid black;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 35px;
            height: 35px;
            border: 2px solid #000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin-right: 8px;
            background-color: #fff;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }
        .contact-info {
            font-size: 9px;
            text-align: right;
            line-height: 1.1;
            max-width: 200px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-panel {
            width: 48%;
            border: 1px solid #000;
            padding: 8px;
        }
        .info-panel h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }
        .info-panel p {
            margin: 3px 0;
            font-size: 10px;
        }
        .label {
            font-weight: bold;
            min-width: 80px;
            display: inline-block;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
            padding: 5px 0;
        }
        .title .khmer {
            font-size: 18px;
            display: block;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #968686;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        .items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            font-size: 9px;
        }
        .items-table .no-col { width: 5%; }
        .items-table .desc-col { width: 75%; }
        .items-table .amt-col { width: 20%; text-align: right; }
        .totals-section {
            width: 35%;
            border: 1px solid #000;
            padding: 8px;
            margin-left: auto;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .totals-section p {
            margin: 4px 0;
            text-align: right;
        }
        .totals-section .label {
            display: inline-block;
            width: 120px;
            text-align: left;
            min-width: unset;
        }
        .bank-section {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .bank-section h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid gray;
            padding-bottom: 3px;
        }
        .bank-section p {
            margin: 3px 0;
        }
        .bank-section .label {
            font-weight:normal;
            min-width: 100px;
            display: inline-block;
        }
        .signatures {
            position: absolute;
            bottom: 15mm;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding-top: 8px;
            font-size: 9px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            padding: 0 10px;
        }
        .khmer {
            font-family: 'Noto Sans Khmer', sans-serif;
        }
        .usd {
            font-family: Arial, sans-serif;
        }
        @media print {
            body { margin: 0; }
            .page { padding: 10mm; }
            .page {
                margin-left: -20px !important;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="logo-container" style="margin-top:-40px">
                 <img width="150px" src="<?=base_url('assets/uploads/logo_help.png')?>">
            </div>
            <div class="contact-info usd">
                Contact Name NHEM KOEHMENG<br>
                Phone (+855) 087 878 382<br>
                National Road No. 2, Phum Tuol Roka, Sangkat Chak Angre Krom, Khan Meanchey, Phnom Penh
            </div>
        </div>

        <div class="info-section">
            <div class="info-panel">
                <h3 class="usd">CUSTOMER INFORMATION</h3>
                <p><span class="label khmer">ឈ្មោះ</span>: Tol Sreynoch</p>
                <p><span class="label khmer">ឈ្មោះក្រុមហ៊ុន/អតិថិជន</span>: DOUNKEO CONCRETE</p>
                <p><span class="label khmer">លេខទូរសព្ទ/Phone</span>: 086 416 161</p>
                <p><span class="label khmer">អាសយដ្ឋាន/Address</span>:  តាកែវ</p>
            </div>
            <div class="info-panel">
                <h3 class="usd">PAYMENT INFORMATION</h3>
                <p><span class="label khmer">កាលបរិច្ឆេទ/Date</span>: Sep 13, 2025</p>
                <p><span class="label khmer">លេខវិក្កយបត្រ/Inoice No</span>: 2509019</p>
                <p><span class="label khmer">កាលបរិច្ឆេទផុតកំណត់</span> Due Date : </p>
                <p><span class="label khmer">អត្រាប្តូរ/Exchange Rate</span>: 4,016 ៛</p>
            </div>
        </div>

        <h2 class="title">
            <span class="khmer" style="font-family: Khmer OS Muol;">វិក្កយបត្រ</span><br>
            <span class="usd">INVOICE</span>
        </h2>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="no-col usd">No.</th>
                    <th class="desc-col usd">Description</th>
                    <th class="amt-col usd">Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no-col">1</td>
                    <td class="desc-col">ធ្វើរបាយការណ៏ស្តុកឆ្នាំ២០២៣ នឹង ២០២៤</td>
                    <td class="amt-col">$ 100.00</td>
                </tr>
                <tr><td class="no-col">&nbsp;</td><td class="desc-col">&nbsp;</td><td class="amt-col">&nbsp;</td></tr>
                <tr><td class="no-col">&nbsp;</td><td class="desc-col">&nbsp;</td><td class="amt-col">&nbsp;</td></tr>
                <tr><td class="no-col">&nbsp;</td><td class="desc-col">&nbsp;</td><td class="amt-col">&nbsp;</td></tr>
                <tr><td class="no-col">&nbsp;</td><td class="desc-col">&nbsp;</td><td class="amt-col">&nbsp;</td></tr>
                <tr><td class="no-col">&nbsp;</td><td class="desc-col">&nbsp;</td><td class="amt-col">&nbsp;</td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align: right;border: none;">Sub-total</th>
                    <th style="text-align:right;">$ 100.00</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right;border: none;">Balance Due (USD)</th>
                    <th style="text-align:right;">$ 100.00</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right;border: none;">Balance Due (KHR)</th>
                    <th style="text-align:right;">៛ 401,600</th>
                </tr>
            </tfoot>
        </table>

        <div class="bank-section">
            <h3 class="usd">OFFICIAL BANK</h3>
            <p><span class="label usd">Bank Name</span>: ABA</p>
            <p><span class="label usd">Account Name</span>: CHHOM PHEA</p>
            <p><span class="label usd">Account Number</span>: 000 730 045</p>
            <img width="70px" src="<?=base_url('assets/uploads/qrcode.jpg')?>">
        </div>

        <div class="signatures usd">
            <div class="signature-box">
                <p>..................................</p>
                Customer Signature & Name
            </div>
            <div class="signature-box">
                <p>..................................</p>
                Seller Signature & Name
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(function() {
        window.print();
    });
</script>