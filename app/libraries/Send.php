<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}
	function send($customer, $products, $address, $total, $reference_no)
    {
    	$email = 'roeunchamnab11122@gmail.com';
    	foreach ($products as $row) {
    		if ($row['color_name'] && $row['size_name']) {
                    $color_name = $row['color_name'] ? '(' . $row['color_name'] . ', ' : '';
                    $size_name = $row['size_name'] ? $row['size_name'] . ')' : '';
                    $variant_name = $color_name . $size_name;
                } elseif ($row['color_name']) {
                    $color_name = $row['color_name'] ? '(' . $row['color_name'] . ')' : '';
                    $variant_name = $color_name;
                } elseif ($row['size_name']) {
                    $size_name = $row['size_name'] ? '(' . $row['size_name'] . ')' : '';
                    $variant_name = $size_name;
                }
    		$items .= '<tr class="row-data">
				<td>Product</td>
				<td width="20">Quatity</td>
				<td width="100">Price</td>
			</tr>
			<tr class="row-data">
				<td>' . $row['product_name'] . $variant_name . '</td>
				<td>'. $row['quantity'] . '</td>
				<td>$ ' . number_format($row['subtotal'], 2, '.', '') . '</td>
			</tr>';
    	}
    	$items .= '<tr class="row-data">
				<td colspan="2">Subtotal</td>
				<td>$ ' . number_format($total, 2, '.', '') . '</td>
			</tr>
			<tr class="row-data">
				<td colspan="2">Payment Method</td>
				<td>Cash On Delivery</td>
			</tr>
			<tr class="row-data">
					<td colspan="2">Total</td>
					<td>$ ' . $total . '</td>
				</tr>';
        $this->ci->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'aplus.855sys.com',
            'smtp_port' => 587,
            'smtp_user' => 'sender@wintech.com.kh',
            'smtp_pass' => 'Admin@855mail',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->ci->email->initialize($config);
        $this->ci->email->set_mailtype("html");
        $this->ci->email->set_newline("\r\n");
        $htmlContent .= '<html lang="en"><head>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1.0">
							<title>Sales</title>
							<style>
								body{
									margin: 0;
								}
								* {
									box-sizing: border-box !important;
								}
								.data, #text{
									max-width: 500px !important;
									width: 100%;
									margin: auto;
									border-collapse: collapse;
									border-spacing: 0px;
								}
								#header{
									max-width: 550px !important;
									width: 100%;
									margin: auto;
									border-collapse: collapse;
									border-spacing: 0px;
									border: none;
									margin-top: 10px;

								}
								.data, .row-data td{
									border: 1px solid gray;
									padding: 4px;
									line-height: 1.3;
								}
								.border-none{
									border: none !important;
									background-color: #97578b;
									line-height: 3.5;
								}
							</style>
						</head>
						<body>
							<table id="header">
								<tbody><tr class="border-none">
									<td colspan="3" style="color: white;">&emsp;&emsp;New Order : ' . $reference_no . ' <br></td>
								</tr>
							</tbody></table><br>
							<table id="text">
								<tbody>
								<tr>
									<td colspan="3">You\'ve recieved the following order from '. $customer .'</td>
								</tr>
								<tr>
									<td colspan="3" style="color:#97578b;">[New Order : ' . $reference_no . '] ('. date('F d Y') .')</td>
								</tr>
							</tbody></table><br>
							<table class="data">
								<tbody>' . $items . '</tbody>
							</table><br>
							<table class="data" style="border: none;">
								<tbody>
								<tr>
									<td style="color: #97578b;">Billing Address</td>
								</tr>
								<tr><td colspan="3" style="border-bottom: 1px solid #dddd;padding-top: 20px;"></td></tr>
								<tr><td colspan="3" style="padding-top: 10px;"> ' . $customer . ' </td></tr>
								<tr><td colspan="3">' . $address . '</td></tr>
							</tbody></table>
						</body></html>';
        $this->ci->email->from('sender@wintech.com.kh', '103 NPT');
        $this->ci->email->to($email);
        $this->ci->email->subject('New Orders From ' . $customer);
        $this->ci->email->message($htmlContent);
        $sent = $this->ci->email->send();
        return $sent;
    }
}