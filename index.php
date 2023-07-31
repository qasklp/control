<!DOCTYPE html>
<html lang="ua" >
    <head>
        <meta charset="utf-8" />
        <title>Scan ticket system</title>
		<link rel="icon" type="image/png" href="favicon.png" />
		<link rel="stylesheet" href="css/main.css" type="text/css" media="all" />


		<link rel="stylesheet" href="css/demopage.css" type="text/css" media="all" />
		<script src="js/!!/jquery.min.js" type="text/javascript"></script>


		<style>
			input[type=checkbox]{
				height: 0;
				width: 0;
				visibility: hidden;
			}

			label {
				cursor: pointer;
				/*text-indent: -9999px;*/
				width: 230px;
				height: 90px;
				/* background: grey; */
				background: #ffff00;
				/*text-decoration: line-through;*/
				color: black;
				display: block;
				/* border-radius: 50px; */
				border-radius: 10px;
				position: relative;
				font-size: 35px;
				padding: 0 15px;
				line-height: 100px;
				text-align: center;
				margin-right: 10px;
			}
			label span {
				position: relative;
				margin: 0 15px;
			}

			/*label:before {
				content: '';
				position: absolute;
				top: 45%;
				left: 10px;
				width: 90%;
				height: 10%;
				background: red;
				border-radius: 90px;
				transition: 0.3s;
				z-index:0;
				transform: rotate(-18deg);
			}*/

			/* -------------------- */
			label:after {
				content: '';
				position: absolute;
				/* top: 5px; */
				top: 45%;
				/* left: 5px; */
				left: 10px;
				/* width: 50%; */
				width: 90%;
				/* height: 80px; */
				height: 10%;
				/* background: #fff; */
				background: red;
				border-radius: 90px;
				transition: 0.3s;
				z-index:0;
				transform: rotate(18deg);
			}
			/* ----------------------- */

			input:checked + label {
				/* background: #bada55; */
				background: #008000;
				color: white;
				text-decoration: none;
				
				
			}

			input:checked + label:before {
				/* left: calc(100% - 5px); */
				/* transform: translateX(-100%); */
				z-index:-1;
			}

			input:checked + label:after {
				/* left: calc(100% - 5px); */
				/* transform: translateX(-100%); */
				z-index:-1;
			}

			label:active:before {
				/* width: 130px; */
			}
			.btn{
				font-size: 1.875rem;
    			line-height: 1;
    			font-weight: 400;
    			border-radius: 15px;
    			width: 200px;
    			height: 83px;
    			cursor: pointer;
			}

			.lenta{
				margin:30px 20px 20px 15px;
				position: fixed;
				top: 400px;
				left: 500px;
			}

			@media (min-width: 1000px) and (max-width: 1800px) {
				.lenta{
					left: 300px;
				}
			}

			@media (min-width: 400px) and (max-width: 980px) {
				.lenta{
					left: 50px;
				}
			}


		</style>
		<?php
			session_start();
			if(!isset($_SESSION['user_id']))      // if there is no valid session
  			{
   		 		header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
  			}else{
  				$user_id = $_SESSION['user_id'];
  			}

			include 'classes.php';
			$event = new Event();
			$set = new Settings();
			$user = new User();
			$activ_event_id = 0;
			$activ_event_name = '';
			$activ_event = $event -> get_active_event();
			if(is_array($activ_event)){
				$activ_event_name = $activ_event['name'];
				$activ_event_id = $activ_event['id'];
			}else{
				$activ_event_name = $activ_event;
			}

		    switch($set->lang){
		      case 'ukr':
		        include 'lang/ukr_lang.php';
		        break;

		      case 'eng':
		        include 'lang/eng_lang.php';
		        break;

		    }
		?>
    </head>
    <body>
    <div style='width:100%;'>
        <header>
            <h2 style='float:left;'><?=event?> <span id='cur_event'><?= $activ_event_name ?>(</span><?=$_SESSION['user_login']?> - <span id='user_count'><?=$user->get_count_by_id($_SESSION['user_id'], $activ_event_id)?></span>)</h2>
            <a href="/admin/logout.php" class="stuts"><img src="/img/logout.png" alt="logout"></a>
            <a href="/admin" class="stuts" target="_blank" ><img src="
            	<?php
            		switch($set->logo){
            			case '1':
            				echo '/img/scan_logo_s.png';
            				break;

            			case '2':
            				echo '/img/karabas_s.png';
            				break;
            		}
            	?>
            	"></span></a>
        </header>

<div id='result_c'style='padding:10px 0; width:100%; height:500px; background-color:gray;'>


<div class='control_text' style='color:white; font-size: 60px; font-weight: bold; margin: 160px 10px; text-align:center;'><div id="big_logo"><img src="/img/scan_logo.jpg" alt="scan_logo"></div><?=ready?></div>

<?php if($set->show_inv == 1):?>
<div id='inv' style='float: left; margin:10px;'><?=inv?></div>
<?php endif;?>


<?php if($set->show_sel == 1):?>
<div id='sel_img' style="margin: 10px; float:right;"></div>
<?php endif;?>

</div>
<table style='width:100%;'><tr>
<td><input type='number' id='code' style='width:300px; height:50px; background-color:yellow; font-size:24px; padding:10px;  margin:10px;'>
<button type="submit" class="btn" id='scan_btn'><?=scan?></button>

</td>

<td style='text-align:center;'>
<?php if($set->show_lenta == 1): ?>
	<div class='lenta'><img src="img/lentas/blue.jpg" id='lenta' alt="lenta" >
	</div>
<?php endif;?>

</td>
<td align="right">
	<?php if($set->exit == 1):?>
<div class='switch'><!--<input type="checkbox" id="switch" style='width:300px;'/><label for="switch"><span>Вихід</span><span>Вхід</span></label>--></div>
	<?php endif;?>
</td>
</tr></table>
</div>
<!--<div style="transform: rotate(90deg); display: inline-block;"><img style="transform: rotate(90deg); src="img/lentas/blue.jpg" id='lenta2' alt="lenta" ></div>-->



<div id='div1'></div>
<!--<div class="examples">

    <button name="sample1" class="sample1">Пример 1 (простой)</button>
    <button name="sample2" class="sample2">Пример 2 (post)</button>
    <button name="sample3" class="sample3">Пример 3 (скрипт)</button>
    <button name="sample4" class="sample4">Пример 4 (xml)</button>
    <button name="sample5" class="sample5">Пример 5 (json)</button>-->

    <script language="javascript" type="text/javascript">
	function play_audio(path){
		var obj = document.createElement('audio');
		obj.src = path;

		<?php if($set->audio == 1):?>
		obj.play();
		<?php endif;?>

	}

	function get_audio_path(type, voice){

		var path = '/sounds/';

		switch(type){
			case 1:
				path += voice + '/again.mp3';
				break;

			case 2:
				path += voice + '/deny.mp3';
				break;

			case 3:
				path += voice + '/exit.mp3';
				break;

			case 4:
				path += voice + '/no_inhall.mp3';
				break;
		}

		return path;
	}

	function scan_code(exit){
		if($('#code').val() != ''){
			//alert('<?=$activ_event_id?>' + ' ' + exit + ' '+ $('#code').val());
	     	$.ajax({
		    	url: 'response.php',
		        data: 'code=' + $('#code').val() + '&event='+ <?= $activ_event_id ?> +'&exit='+ exit + '&user_id=' + <?= $user_id ?>,
				dataType: 'json',
				/*error:err=>{
                   //$('#result_c').css('backgroundColor', '#ab9998');
				   //$('.control_text').html('Серевер не відповідає!');
                    alert("Серевер не відповідає!");
                },*/
		        success: function(data){
		        //alert(data[0].status);

			        //ВХОД В ЗАЛ
					if(data[0].status == 1 ){
						//alert(data[0].fan);
						$('#sel_img').empty();
						$('#result_c').css('backgroundColor', '#0d13ff');

						if(data[0].inv == 1){
							$('#inv').show();
						}else{
							$('#inv').hide();
						}

						if(data[0].img !=''){
							$('#sel_img').prepend('<img src="' + data[0].img + '" />');
							$('#sel_img').show();
						}

						<?php //$event->get_is_inv($activ_event_id) ?>
						//$('.control_text').html('Зона: Фан-зона Ряд: 1 Місце: 2');
						//$('#inv').show();
						//var j = toString(data);
						//var j = '[{"zone":2,"row":2,"col":1}]';
						//var json = JSON.parse(data);
						if(data[0].fan == 0){
							$text = '<?=zone?> '+ data[0].zone +' <?=row?> '+ data[0].row +' <?=place?> ' + data[0].col;
						}

						if(data[0].fan == 1){
							$text = '<?=zone?> '+ data[0].zone;
						}

						if(data[0].lenta != ''){
							$('#lenta').show();
							$('#lenta').attr('src', data[0].lenta);
						}

						//console.log(data[0].zone);
						//alert( data[0].zone_id);

						$('.control_text').html($text);

						//$('#user_count').html(<?= $user->get_count_by_id($_SESSION['user_id'], $activ_event_id) ?>);
						$('#user_count').html(data[0].user_count);

						$('#code').val(null);

						<?php if($set->voice != 'audio'): ?>
							var zone_audio = '/sounds/'+'<?=$set->voice?>'+'/zones/'+ data[0].zone_id + '.mp3';
							/*alert(zone_audio);*/
						<?php else: ?>
							var zone_audio = '/sounds/audio/enter.wav';
						<?php endif; ?>
									//alert(zone_audio);

								play_audio(zone_audio);


						if(data[0].zaudio != ''){
							setTimeout(function(){
								play_audio(data[0].zaudio);
							}, 1100);
						}
									/*var obj = document.createElement('audio');
								    obj.src = '/sounds/Enter5.wav';
								    obj.play();*/
					}

					//ПОВТОРНЫЙ ВХОД
					if(data[0].status == 2 ){
						$('#result_c').css('backgroundColor', '#ff8a00');

						var repit_mass = data[0].repit.split('#');
						$text = '<?=entrance?> ' + data[0].time +'<br/>';

						$text += '<div style="font-size:50px;"><?=again?><br/>';

						repit_mass.forEach(function(entry) {
		   					$text += entry + '<br/>';
						});


						$text +='</div>';
						//console.log(data[0].zone);
						$('.control_text').css({"margin-top":"170px","margin-right":"10px","margin-bottom":"180px","margin-left":"10px"});;
						$('.control_text').html($text);
						$('#code').val(null);
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
						play_audio(get_audio_path(1,'<?=$set->voice?>'));
					}

					//НЕТ В БАЗЕ
					if(data[0].status == 0){
						$('#result_c').css('backgroundColor', '#ee0e0e');
						$('.control_text').html('<?=unknowbar?>');
						$('#code').val(null);
						//alert('/sounds/'+ <?=$set->voice?> + '/deny.mp3');
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
						play_audio(get_audio_path(2,'<?=$set->voice?>'));
					}

					//ВЫШЕЛ ИЗ ЗАЛА
					if(data[0].status == 3){
						$('#result_c').css('backgroundColor', 'green');
						if(data[0].fan == 0){
							$text = '<?=exit2?> '+ data[0].zone +' <?=row?> '+ data[0].row +' <?=place?> ' + data[0].col;
						}

						if(data[0].fan == 1){
							$text = '<?=exit2?> '+ data[0].zone;
						}
						$('.control_text').html($text);
						$('#code').val(null);
						play_audio(get_audio_path(3,'<?=$set->voice?>'));
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
					}

					//НЕТ В ЗАЛЕ
					if(data[0].status == 5){
						$('#result_c').css('backgroundColor', '#ee0e0e');
						$('.control_text').html('<?=noinhall?>');
						$('#code').val(null);
						play_audio(get_audio_path(4,'<?=$set->voice?>'));
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
					}

					//НЕ ТА ЗОНА ВХОДА
					if(data[0].status == 4){
						$('#result_c').css('backgroundColor', '#0bb7ff');
						$('.control_text').html('<?=wrongz?> (' + data[0].zone + ')');
						$('#code').val(null);
						play_audio(get_audio_path(2,'<?=$set->voice?>'));
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
					}

				}

        	}).fail(function() {
    			$('#result_c').css('backgroundColor', '#ab9998');
    			$('.control_text').html('<?=noresp?>');
 			 });
	 	}else{
	 	   	$('#result_c').css('backgroundColor', '#ed1ab9');
			$('.control_text').html('<?=nobar?>');
	 	}
	}


	$(document).keypress(function(e) {
    	if(e.which == 13) {
    		var exit = 0;

    		if($('#switch').attr('checked')){
       			var exit = 1;
      		  }

      		  if($('.form-check-input').attr('checked')){
       			var exit = 1;
      		}

      		$('.control_text').css({"margin-top":"160px","margin-right":"10px","margin-bottom":"160px","margin-left":"10px"});
			scan_code(exit);
			$('#result_c').fadeOut(100);
			$('#result_c').fadeIn(100);
		}
	});

	$( document ).ready(function() {

		$('#scan_btn').click( function() {
			var exit = 0;

    		if($('#switch').attr('checked')){
       			var exit = 1;
      		}

      		if($('.form-check-input').attr('checked')){
       			var exit = 1;
      		}

      		//alert($(".switch").val());
      		$('.control_text').css({"margin-top":"160px","margin-right":"10px","margin-bottom":"160px","margin-left":"10px"});
			scan_code(exit);
			$('#result_c').fadeOut(100);
			$('#result_c').fadeIn(100);

    	});

    	$('#code').focus();
		$('#inv').hide();
		$('#sel_img').hide();
		$('#lenta').hide();
    });

		var agent = navigator.userAgent.toString();
		var ver = '30.0';

		var pos = -1;
		var pos2 = -1;

		var exit = "<?=exit1?>";

		while((pos = agent.indexOf(ver, pos+1)) != -1){
			pos2 = pos;
		}

		if(pos2 != -1){
			$('.switch').html('<span style="margin:0 20px 20px 0; font-size:34px; vertical-align: text-bottom;">exit</span><input type="checkbox" class="form-check-input" style="width:50px; height:50px; margin-top: 30px; visibility: initial;">');
		}else{
			//$('.switch').html('<span style="margin:0 20px 0 0; font-size:34px; vertical-align: text-bottom;">Вихід</span><input type="checkbox" class="form-check-input" style="width:50px; height:50px; margin-top: 30px; visibility: initial;">');
			// $('.switch').html('<input type="checkbox" id="switch" /><label for="switch"><span>Вихід</span><span>Вхід</span></label>');
			$('.switch').html('<input type="checkbox" id="switch" /><label for="switch"><span>'+exit+'</span></label>');
		}

		$('#switch').click( function() {

	       if($('#switch').attr('checked')){
	       		$('#code').css('backgroundColor', 'green');
	       }else{
	       		$('#code').css('backgroundColor', 'yellow');
	       }
	       $('#code').focus();
	    });

	    $('.form-check-input').click( function() {

	       if($('.form-check-input').attr('checked')){
	       		$('#code').css('backgroundColor', 'green');
	       }else{
	       		$('#code').css('backgroundColor', 'yellow');
	       }
	       $('#code').focus();
	    });
	
    </script>

   <!-- <div class="results">Ждем ответа</div>-->
	</div>

    </body>
</html>