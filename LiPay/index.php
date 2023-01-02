<?php include('../header_ten.php'); 
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_payment.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_fare.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
    }
?>
<section class="content-header">
  <h1><?php echo $_data['text_1'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>t_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

<head>
    <meta charset="UTF-8">
    <title>Lipa Na M-Pesa</title>
    <link rel="stylesheet" href="style.css">
    
    
</head>

<body>
        <div class="holder1">
            <small>LiPay Gateway</small>
        </div>
    <div class="host"><div class="subhost1 ">
        <h1 class="hero ">Pay your <br> Rent</h1>
    </div>
    <div class="subhost2">
            <div class="card mt-5 px-3 py-4">
                <div class="d-flex flex-row justify-content-around">
                    <div class="mpesa"><span>Mpesa </span></div>
                    <div><span>Paypal</span></div>
                    <div><span>Card</span></div>
                </div>
                <div class="media mt-4 pl-2">
                    <img src="./images/1200px-M-PESA_LOGO-01.svg.png" class="mr-3" height="85" /> <br>
                    
                    <div class="media-body">
                        <h6 class="mt-1">Enter Amount & Number</h6>
                    </div>
                    <div>
                    <?php
				    $result = mysqli_query($link,"Select *,fl.floor_no as fl_floor,u.unit_no as u_unit,r.r_name,m.month_name from tbl_add_fair f inner join tbl_add_floor fl on fl.fid = f.floor_no inner join tbl_add_unit u on u.uid = f.unit_no inner join tbl_add_rent r on r.r_unit_no = f.unit_no inner join tbl_add_month_setup m on m.m_id = f.month_id where f.unit_no = ".(int)$_SESSION['objLogin']['r_unit_no']." and f.branch_id = ".(int)$_SESSION['objLogin']['branch_id']." order by f.month_id ASC");
				        while($row = mysqli_fetch_assoc($result)){
					    $image = WEB_URL . 'img/no_image.jpg';	
			            if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){
				        $image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];
			            }
                    ?>
                
                </div>
            
                <div class="media mt-3 pl-2">
                    <!--bs5 input-->
                    <form class="row g-3" action="./index.php" method="POST">
                        
                        <?php
                            if($row['bill_status']=='0'){
                                $ams_helper->currency($localization, $row['total_rent']);
                                $snow = $row['total_rent'];
                            }
                            else if($row['bill_status']=='1'){
                                $snow = "No Rent Due";
                            }

                        
                         } mysqli_close($link);$link = NULL; ?>
                        <br>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">Amount</label>
                            <input readonly="read-only" type="text" class="form-control" name="amount" placeholder="<?php echo $snow?>">
                        </div>
                        
                        <br>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" placeholder="e.g: 0712345678">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success" name="submit" value="submit">pay</button>
                        </div>
                    </form>
                    <!--bs5 input-->
                </div>
            </div>
        </div>
    </div>
    </div>
       
<?php

if(isset($_POST['submit'])){

    $amount = $snow; //Amount to transact 
    $phone = $_POST['phone']; // Phone number paying
    
    $Account_no = 'ZUMO KE'; // Enter account number optional
    $url = 'https://tinypesa.com/api/v1/express/initialize';
    $data = array(
        'amount' => $amount,
        'msisdn' => $phone,
        'account_no'=>$Account_no
    );
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'ApiKey: dqxCoX31Gac' // Replace with your api key
     );
    $info = http_build_query($data);
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $info);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($curl);
    $msg_resp = json_decode($resp);
    
    
    if ($msg_resp ->success == 'true') {
        echo "WAIT FOR  STK POP UP🔥";
      } else {
        echo "Transaction Failed";
       
      }
}


?>

<?php include('../footer.php'); ?>