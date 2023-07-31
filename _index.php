<!DOCTYPE html>
<html lang="ru" >
    <head>
        <meta charset="utf-8" />
        <title>Scan ticket system</title>
		<link rel="icon" type="image/png" href="favicon.png" />
		<link rel="stylesheet" href="css/main.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/demopage.css" type="text/css" media="all" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
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
				background: grey;
				display: block;
				border-radius: 50px;
				position: relative;
				font-size: 35px;
				padding: 0 15px;
				line-height: 100px;
				text-align: center;
			}
			label span {
				position: relative;
				margin: 0 15px;
			}
			label:before {
				content: '';
				position: absolute;
				top: 5px;
				left: 5px;
				width: 50%;
				height: 80px;
				background: #fff;
				border-radius: 90px;
				transition: 0.3s;
				z-index:0;
			}

			input:checked + label {
				background: #bada55;
			}

			input:checked + label:before {
				left: calc(100% - 5px);
				transform: translateX(-100%);
			}

			label:active:before {
				width: 130px;
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

		</style>
		<?php
			include 'classes.php';
			$event = new Event();
			$set = new Settings();
			$activ_event_id = 0;
			$activ_event_name = '';
			$activ_event = $event -> get_active_event();
			if(is_array($activ_event)){
				$activ_event_name = $activ_event['name'];
				$activ_event_id = $activ_event['id'];
			}else{
				$activ_event_name = $activ_event;
			}
		?>
    </head>
    <body>
    <div style='float:left; display: inline-block; width:100%;'>
        <header>
            <h2 style='float:left;'>Подія: <span id='cur_event'><?= $activ_event_name ?></span></h2>
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
        
<div id='result_c'style='padding:10px 0; width:100%; height:650px; background-color:gray;'>


<div class='control_text' style='color:white; font-size: 60px; font-weight: bold; margin: 260px 10px; text-align:center;'><div id="big_logo"><img src="/img/scan_logo.jpg" alt="scan_logo"></div>Система готова до сканування</div>

<?php if($set->show_inv == 1):?>
<div id='inv' style='float: left; margin:10px;'>ЗАПРОШЕННЯ</div>
<?php endif;?>


<?php if($set->show_sel == 1):?>
<div id='sel_img' style="margin: 10px; float:right;"></div>
<?php endif;?>

</div>
<table style='width:100%;'><tr>
<td><input type='text' id='code' style='width:300px; height:50px; background-color:yellow; font-size:24px; padding:10px;  margin:10px;'>
<button type="submit" class="btn" id='scan_btn'>Скан</button>
</td>

<td style='text-align:center;'>

<?php if($set->show_lenta == 1): ?>
	<div style='margin:30px 20px 20px 15px;'>
	</div>
<?php endif;?>

</td>
<td align="right">
	<?php if($set->exit == 1):?>
		<input type="checkbox" id="switch" style='width:300px;'/><label for="switch"><span>Вихід</span><span>Вхід</span></label>
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

	    $('#switch').click( function() {

	       if($('#switch').attr('checked')){
	       		$('#code').css('backgroundColor', 'green');
	       }else{
	       		$('#code').css('backgroundColor', 'yellow');
	       }
	       $('#code').focus();
	    });
	
    $('#codecontrol').click( function() {
       
		var j ='[{"id":"1","name":"test1"},{"id":"2","name":"test2"},{"id":"3","name":"test3"},{"id":"4","name":"test4"},{"id":"5","name":"test5"}]';
		var json = JSON.parse(j);
		console.log(json.name);
		
		for (let i=0; i<json.length; i++){
			$('#div1').append(json[i].id + ' - ' + json[i].name + '<br>');
		}
/*	   $.ajax({
          type: 'POST',
          url: 'response.php?action=sample2',
          data: 'code=' + $('#code').val(),
          success: function(data){
		  
		  if(data == '1'){
				$('#result_c').css('backgroundColor', '#00ff42');
				$('.control_text').html('Зона: Фан-зона Ряд: 1 Место: 2');
		  }
		  
		  if(data == '2'){
				$('#result_c').css('backgroundColor', '#ee0e0e');
				$('.control_text').html('Билета нет в базе данных');
		  }
			
            
          }
        });*/

    });


    $('.sample4').click( function() {

        $.ajax({
          dataType: 'xml',
          url: 'response.php?action=sample4',
          success: function(xmldata){
            $('.results').html('');
            $(xmldata).find('item').each(function(){
                $('<li></li>').html( $(this).text() ).appendTo('.results');
            });
          }
        });

    });
	
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
	        	 data: 'code=' + $('#code').val() + '&event='+ <?= $activ_event_id ?> +'&exit='+ exit,
			  	 dataType: 'json',
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
							$text = 'Зона: '+ data[0].zone +' Ряд: '+ data[0].row +' Місце: ' + data[0].col;
						}

						if(data[0].fan == 1){
							$text = 'Зона: '+ data[0].zone;
						}

						if(data[0].lenta != ''){
							$('#lenta').show();
							$('#lenta').attr('src', data[0].lenta);
						}

							//console.log(data[0].zone);
							//alert( data[0].zone_id);


						$('.control_text').html($text);

						$('#code').val(null);
						<?php if($set->voice!='audio'): ?>
							var zone_audio = '/sounds/'+'<?=$set->voice?>'+'/zones/'+ data[0].zone_id + '.mp3';
							/*alert(zone_audio);*/
						<?php else: ?>
							var zone_audio = '/sounds/audio/enter.wav';
						<?php endif; ?>
						//alert(zone_audio);
						play_audio(zone_audio);
						/*var obj = document.createElement('audio');
					    obj.src = '/sounds/Enter5.wav';
					    obj.play();*/

					}

					//ПОВТОРНЫЙ ВХОД
					if(data[0].status == 2 ){
						$('#result_c').css('backgroundColor', '#ff8a00');

						var repit_mass = data[0].repit.split('#');
						$text = 'Вхід у зал : ' + data[0].time +'<br/>';

						$text += '<div style="font-size:50px;">Повторний скан :<br/>';

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
						$('.control_text').html('Квиток відсутній у базі даних');
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
							$text = 'Вихід ' + 'Зона: '+ data[0].zone +' Ряд: '+ data[0].row +' Місце: ' + data[0].col;
						}

						if(data[0].fan == 1){
							$text = 'Вихід ' +'Зона: '+ data[0].zone;
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
						$('.control_text').html('Квитка немає в залі');
						$('#code').val(null);
						play_audio(get_audio_path(4,'<?=$set->voice?>'));
						$('#inv').hide();
						$('#sel_img').hide();
						$('#lenta').hide();
					}

					//НЕ ТА ЗОНА ВХОДА
					  if(data[0].status == 4){
							$('#result_c').css('backgroundColor', '#0bb7ff');
							$('.control_text').html('Не та зона входу (' + data[0].zone + ')');
							$('#code').val(null);
							play_audio(get_audio_path(4,'<?=$set->voice?>'));
							$('#inv').hide();
							$('#sel_img').hide();
							$('#lenta').hide();
					  }

		          }

        	});
	 	   }
	}

	$(document).keypress(function(e) {
    	if(e.which == 13) {
    		var exit = 0;

    		if($('#switch').attr('checked')){
       			var exit = 1;
      		  }
      		$('.control_text').css({"margin-top":"260px","margin-right":"10px","margin-bottom":"260px","margin-left":"10px"});
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
      		$('.control_text').css({"margin-top":"260px","margin-right":"10px","margin-bottom":"260px","margin-left":"10px"});
			scan_code(exit);
			$('#result_c').fadeOut(100);
			$('#result_c').fadeIn(100);

    	});

		$('#code').focus();
		$('#inv').hide();
		$('#sel_img').hide();
		$('#lenta').hide();
		//alert(get_audio_path(1,'<?=$set->voice?>'));
		/*$.ajax({
          //dataType: 'json',
          url: '/active_event.php',
          success: function(data){
            $('#cur_event').html(data);
          }
        });*/
	});
	
    </script>

   <!-- <div class="results">Ждем ответа</div>-->
	</div>

    </body>
</html>