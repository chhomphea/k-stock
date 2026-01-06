<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $page_title.' | '.$Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <?php if ($this->db->dbdriver != 'sqlite3') { ?>
    <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?=site_url('login')?>'; }</script>
    <?php } ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css" />
    <?= $Settings->rtl ? '<link href="'.$assets.'dist/css/rtl.css" rel="stylesheet" />' : ''; ?>
</head>
<style type="text/css">
	td{
		padding: 4px !important;
		text-align: left !important;
		font-weight: 600;
		font-size: 25px !important;
	}
	@font-face {
        font-family: khmeros_batt;
        src: url('<?= $assets ?>font/KhmerOS_battambang.ttf');
    }
    p{
    	font-family: 'khmeros_batt' !important;
    }
    td{
    	font-family: 'khmeros_batt' !important;
    }
	body{
		font-size: 25px !important;
	}
	h4{
		font-size: 30px;
	}
</style>
<body>
    <div class="login-box" style="width: 500px !important;">
    	<div class="col-md-12">
    		<h4 class="text-center"><?=$Settings->site_name?></h4>
    		<h4 class="text-center">Order</h4>
    	</div>
    	<div class="row">
    		<div class="col-md-6" style="float: left !important;">
	    		<p style="font-weight: 600; font-size: 30px !important;"><?=lang('លេខកម្មង់')?></p>
	    		<p style="font-weight: 600; font-size: 30px !important;"><?=lang('table')?></p>
	    		<p><?=lang('user')?></p>
	    		<p><?=lang('Pax')?></p>
	    		<p><?=lang('date')?></p>
	    	</div>
	    	<div class="col-md-6" style="float: left !important;">
	    		<p style="font-weight: 600; font-size: 30px !important;"><?=$quer_no?></p>
	    		<p style="font-weight: 600; font-size: 30px !important;"><?=$inv->customer_name?></p>
	    		<p><?=$user->first_name . $user->last_name?></p>
	    		<p><?=$inv->total_people?></p>
	    		<p><?=date('Y-m-d h:i A')?></p>
	    	</div>
    	</div>
    	<table style="width: 100%;">
    		<tbody>
    			<?php $i=1; foreach ($item as $key => $row): ?>
    				<?php 
    					$comment = '';
    					if ($row->comment!='') {
    						$comment = '<br> <small> &nbsp&nbsp * Remark :'.$row->comment.'</small>';
    					}
    					$modify_name 		 = '';
    					if ($row->modify_name!='' AND $row->modify_name !='undefined') {
    						$modify_name 	 = '<br> <small>&nbsp&nbsp - Add On :'.str_replace(",","<br> &nbsp&nbsp - Add On :",$row->modify_name).'</small>';
    					}
    				 ?>
    				<tr>
	    				<td style="text-align: left !important;vertical-align: middle !important;"><?=$i?></td>
	    				<td style="text-align: left !important;vertical-align: middle !important;"><?=str_replace('/','<br>',$row->product_name)?> <?=$comment?> <small><?=$modify_name?></small></td>
	    				<td style="text-align: left !important;vertical-align: middle !important;"><?=$row->quantity*1?></td>
	    			</tr>
    			<?php $i++; endforeach ?>
    		</tbody>
    	</table>
    </div>
    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?= $assets ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $assets ?>plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            if ($('#identity').val())
                $('#password').focus();
            else
                $('#identity').focus();
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>
</html>
