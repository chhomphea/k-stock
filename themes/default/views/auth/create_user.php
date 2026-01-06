<!DOCTYPE html>
<html dir="ltr">
 <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Monster Template by WrapPixel</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/images/favicon.png"/>
    <link href="<?=base_url()?>assets/css/style.min.css" rel="stylesheet" />
  </head>
  <body>
    <div class="main-wrapper">
      <div class="preloader">
      </div>
      <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
        <div class="auth-box p-4 bg-white rounded">
          <div id="loginform">
            <div class="logo">
              <h3 class="box-title mb-3">Sign In</h3>
            </div>
            <div class="row">
              <div class="col-12">
                <form class="form-horizontal mt-3 form-material" id="loginform" action="<?=base_url("login")?>">
                  <div class="form-group mb-3">
                    <div class="">
                      <input class="form-control" type="text" required="" placeholder="Username"/>
                    </div>
                  </div>
                  <div class="form-group mb-4">
                    <div class="">
                      <input class="form-control" autocomplete="off" type="password" required="" placeholder="Password"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-flex">
                      <div class="checkbox checkbox-info pt-0">
                        <input id="checkbox-signup" autocomplete="off" type="checkbox" class="material-inputs chk-col-indigo"
                        />
                        <label for="checkbox-signup"> Remember me </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group text-center mt-4 mb-3">
                    <div class="col-xs-12">
                      <button class=" btn btn-info d-block w-100 waves-effect waves-light" type="submit">
                        Log In
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center">
                      <div class="social mb-3">
                        <a href="javascript:void(0)" class="btn btn-facebook" data-bs-toggle="tooltip" title="Login with Facebook"> 
                            <i aria-hidden="true" class="fab fa-facebook-f"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-googleplus" data-bs-toggle="tooltip" title="Login with Google">
                            <i aria-hidden="true" class="fab fa-google"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    <script>
      $(".preloader").fadeOut();
      $("#to-recover").on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
      });
    </script>
  </body>
</html>
=======
<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                    <div class="col-lg-6">
                        <?= form_open('auth/create_user','class="validation"'); ?>
                        <div class="form-group">
                            <?= lang('first_name', 'first_name'); ?>
                            <?= form_input('first_name', set_value('first_name'), 'class="form-control tip" id="first_name"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('last_name', 'last_name'); ?>
                            <?= form_input('last_name', set_value('last_name'), 'class="form-control tip" id="last_name"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('phone', 'phone'); ?>
                            <?= form_input('phone', set_value('phone'), 'class="form-control tip" id="phone"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('gender', 'gender'); ?>
                            <?php $gnders = array('male' => lang('male'), 'female' => lang('female')); ?>
                            <?= form_dropdown('gender', $gnders, set_value('gender'), 'class="form-control tip select2" style="width:100%;" id="gender"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('email', 'email'); ?>
                            <?= form_input('email', set_value('email'), 'class="form-control tip" id="email"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('username', 'username'); ?>
                            <?= form_input('username', set_value('username'), 'class="form-control tip" id="username"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('password', 'password'); ?>
                            <?= form_password('password', '', 'class="form-control tip" id="password"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('confirm_password', 'confirm_password'); ?>
                            <?= form_password('confirm_password', '', 'class="form-control tip" id="confirm_password"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang('status', 'status'); ?>
                            <?php
                            $opt = array('' => '', 1 => lang('active'), 0 => lang('inactive'));
                            echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="status" data-placeholder="' . lang("select") . ' ' . lang("status") . '" class="form-control input-tip select2" style="width:100%;"');
                            ?>
                        </div>
                    
                        <div class="form-group">
                            <?= form_submit('add_user', lang('add_user'), 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    <div class="box-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= lang("group", "group"); ?>
                            <?php
                            $gp[""] = "";
                            foreach ($groups as $group) {
                                $gp[$group['id']] = $group['name'];
                            }
                            echo form_dropdown('group', $gp, set_value('group'), 'id="group" data-placeholder="' . lang("select") . ' ' . lang("group") . '" class="form-control input-tip select2" required="required" style="width:100%;"');?>
                        </div>
                        <div class="form-group store-con">
                            <?= lang("store", "store_id"); ?>
                            <?php
                            $st[""] = "";
                            foreach ($stores as $store) {
                                $st[$store->id] = $store->name;
                            }
                            echo form_dropdown('store_id', $st, set_value('store_id'), 'id="store_id" data-placeholder="' . lang("select") . ' ' . lang("store") . '" class="form-control input-tip select2" style="width:100%;"');
                            ?>
                        </div>
                        <div class="form-group store-con">
                            <?= lang("printer", "printer_id"); ?>
                            <?php
                            $pr[""] = "";
                            foreach ($printers as $print) {
                                $pr[$print->id] = $print->title;
                            }
                            echo form_dropdown('printer', $pr, set_value('printer'), 'id="printer_id" data-placeholder="' . lang("select") . ' ' . lang("printer") . '" class="form-control input-tip select2" style="width:100%;"');
                            ?>
                        </div>
                        <div class="panel panel-primary store-con">
                            <div class="panel-heading"><?= lang('User Permission') ?></div>
                            <div class="panel-body" style="padding: 5px;">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                            <?= lang('show_all_record', 'show_all_record'); ?>
                                            <?php
                                            $opt = array('' => '', 1 => lang('enable'), 0 => lang('disable'));
                                            echo form_dropdown('show_all_record', $opt, (isset($_POST['show_all_record']) ? $_POST['show_all_record'] : ''), 'id="status" data-placeholder="' . lang("please") . ' ' . lang("select") . '" class="form-control input-tip select2" style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="form-group">
                                            <?= lang('edit_price_sell', 'edit_price_sell'); ?>
                                            <?php
                                            $opt = array('' => '', 1 => lang('enable'), 0 => lang('disable'));
                                            echo form_dropdown('edit_price_sell', $opt, (isset($_POST['edit_price_sell']) ? $_POST['edit_price_sell'] : ''), 'id="status" data-placeholder="' . lang("please") . ' ' . lang("select") . '" class="form-control input-tip select2" style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="form-group">
                                            <?= lang('allow_discount', 'allow_discount'); ?>
                                            <?php
                                            $opt = array('' => '', 1 => lang('enable'), 0 => lang('disable'));
                                            echo form_dropdown('allow_discount', $opt, (isset($_POST['allow_discount']) ? $_POST['allow_discount'] : ''), 'id="status" data-placeholder="' . lang("please") . ' ' . lang("select") . '" class="form-control input-tip select2" style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- <div class="form-group store-con">
                            <label class="checkbox" for="show_all_record"><input type="checkbox" name="show_all_record" value="1" id="show_all_record" checked="checked"/> <?= lang('show_all_record') ?></label>
                        </div>
                        <div class="form-group store-con">
                            <label class="checkbox" for="edit_price_sell"><input type="checkbox" name="edit_price_sell" value="1" id="edit_price_sell" checked="checked"/> <?= lang('edit_price_sell') ?></label>
                        </div>
                        <div class="form-group store-con">
                            <label class="checkbox" for="allow_discount"><input type="checkbox" name="allow_discount" value="1" id="allow_discount" checked="checked"/> <?= lang('allow_discount') ?></label>
                        </div> -->
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</section>

>>>>>>> =update
