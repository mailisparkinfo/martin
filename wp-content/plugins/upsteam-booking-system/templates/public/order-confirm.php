<?php 
/* Template Name: OrderConfirm */ 


//error_log("Get parameters: ".implode(", ",$_GET));
//error_log("Post parameters: ".implode(", ",$_POST));

if(isset($_GET['redirect']) && $_GET['redirect'] == 'callback'){
	everyPayCallback();
	return;
}


$result = everyPayMerchantRedirect();

$message = $result && $_POST['transaction_result'] == 'completed' ? "Täname, et olete sooritanud makse!" : "Makse tegemine ei õnnestunud";

?>


<style>

.bg-dark {
    background-color: #fff !important;
}
</style>
<?php get_theme_master_header(); ?>

<section class="regular-content">
	<div class="container" style="margin-top: 50px;">
		<div class="row" style="    margin-right: auto;
    margin-left: auto;
    width: 280px !important;">
	<img src="http://upsteam.89.ee/wp-content/uploads/2018/01/ring.png" width="133" height="133" style="margin-left: auto;
    margin-right: auto;
    margin-bottom: 30px;">

			<div class="col-md-12 white" style="text-align: center; width: 270px !important;">
				<h1 style="color: #39a4ff !important; font-size: 24px;
  height: 72.7px;
  font-family: GothamPro;
  font-size: 24px;
  font-weight: bold;
  font-style: normal;
  font-stretch: normal;
  line-height: 1.51;
  letter-spacing: normal;
  text-align: center;
  color: #39a4ff;
  color: var(--blue); margin-bottom: 30px;"><?=$message?></h1>
				<?php //var_dump($_POST);?>
			</div>
	<a class="btn btn-default btn-blue big-second" href="https://upsteam.89.ee/" style="height: 36;
    font-family: GothamPro;
    font-size: 14px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    /* line-height: 2.59; */
    letter-spacing: normal;
    text-align: center;
    color: #ffffff !important;
    color: var(--white); padding: 0.5rem 1rem !important; text-transform:none !Important; margin-right: 5px;">Edasi</a>		
			<a class="btn btn-default btn-blue big-second" href="https://upsteam.89.ee/profiil/" style="height: 36;
    font-family: GothamPro;
    font-size: 14px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    /* line-height: 2.59; */
    letter-spacing: normal;
    text-align: center;
    color: #ffffff !important;
    color: var(--white); padding: 0.5rem 1rem !important; text-transform:none !Important;">Täienda oma andmeid</a>	
		</div>
		<div class="col-md-12 pb-5">
<div class="col-md-12 pt-4">
<p class="green-text">NB! Palume parkida auto kohta, kuhu oleks UpSteam meeskonnal võimalik maksimaalselt 5m kaugusele parkida (Teie auto kõrvale pargitud autod ei ole takistuseks). Tallinna piiridest kuni 7km välja poole tellimisel lisandub töö hinnale pikema sõidu tõttu
+5€. *Äärmiselt tugevalt määrdunud auto puhul võtab UpSteam Teiega enne teenuse osutamist ise ühendust ja võib määrata töö eest kokkuleppelise lisatasu.</p>
</div>

</div>
  </div>
</section>


<?php
get_theme_master_footer();
?>
