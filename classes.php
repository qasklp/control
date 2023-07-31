<?php

	abstract class connection_bd{
		private $servername = "control";
		private $username = "root";
		private $password = "root";
		private $dbname = "control_tickets";
		protected $mysqli;

		function __construct() {
       		$this->mysqli =  new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($this->mysqli->connect_errno) {
				echo "Не удалось подключиться к MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
			}
  		 }

		function __destruct() {
			 $this->mysqli->close();
		}

	}//*** connection_bd


	class Zone extends connection_bd{
		public $id;
		public $name;
		public $zone_hall;
		public $is_fan;

		function get_zones_by_event($event){
			$zones = Array();

			$sql = "SELECT z.id as 'zid', z.sector as 'zname' FROM eventplace e JOIN zone z ON e.zone = z.id WHERE e.event = {$event} GROUP BY zid";
			$count = 0;
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$zones[$count]['zid'] = $row["zid"];
					$zones[$count]['zname'] = $row["zname"];
					$count ++;
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $zones;

		}

		function insert_zone($name, $hall_id, $is_fan){
			$fan = 0;
			if($is_fan == 1){
				$fan = 1;
			}

			return $this->mysqli->query("INSERT INTO zone (`id`, `sector`, `hall`, `is_fan`, `img`, `audio`) VALUES (NULL, '{$name}', {$hall_id}, {$fan}, '', '')");
		}

		function get_zones_by_id($zone_id){

			$zone_name = "";

			$sql = "SELECT z.sector as 'zname' FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$zone_name = $row["zname"];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $zone_name;

		}

		//Получить список популярных зон
		function get_zone_select(){
			$zone_html = '';
			$sql = "SELECT * FROM zone z WHERE z.hall = 0";
			$zone_html .= "<select name='zones' id='zones' class='js-example-basic-single w-100' style='float:left; width:50%;'>";

			 switch(Settings::GetLang()){

			      	case 'ukr':
						$zone_html .= "<option value='0'>Вибрати зону</option>";
		            break;

					case 'eng':
					    $zone_html .= "<option value='0'>Choose a zone</option>";
		            break;
				}


			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$zone_html .= "<option  value='".$row['id']."' isfan='".$row['is_fan']."'>".$row['sector']."</option>";
				}
					$result->free();
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}
				$zone_html .= "</select>";
				return $zone_html;
			}//****Получить популярных зон

		function get_zones_ids($event){

			$zones = "";
			$last = false;
			$count = 1;

			$sql = "SELECT z.id as 'zid' FROM event e JOIN hall h ON h.id = e.hall JOIN zone z ON z.hall = h.id WHERE e.id = {$event} ";
			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;

				foreach($result as $row){
					if($count == $rowsCount){
						$last = true;
					}

					if(!$last){
						$zones .= $row["zid"].", ";
					}else{
						$zones .= $row["zid"];
					}

					$count++;
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $zones;
		}

		function zone_place_count($zone_id, $event_id, $status){
			$count = 0;
			$sql = "SELECT count(p.id) as 'count' FROM eventplace p WHERE p.zone = {$zone_id} AND p.event = {$event_id} AND p.status = {$status}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$count = $row['count'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $count;
		}

		function get_lenta($zone_id){
			$img = '';
			$sql = "SELECT z.img as 'img' FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$img = $row['img'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $img;
		}

		function get_audio($zone_id){
			$audio = '';
			$sql = "SELECT z.audio as 'audio' FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$audio = $row['audio'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $audio;
		}

		function is_fan($zone_id){
			$is_fan = 0;
			$sql = "SELECT z.is_fan as 'is_fan' FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$is_fan = $row['is_fan'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $is_fan;
		}

		function zone_hall_id($zone_id){
			$sql = "SELECT z.hall FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->zone_hall = $row['hall'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $this->zone_hall;
		}

		function zone_name($zone_id){
			$sql = "SELECT z.sector FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->name = $row['sector'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $this->name;
		}
	}//*** class Zone

	class Scanlog extends connection_bd{

		function get_scanlog_titles_for_excel(){
			$titles = [
				array(
					'title' => 'ID',
					'cell' => 'A'
				),
				array(
					'title' => 'Штрихкод',
					'cell' => 'B'
				),
				array(
					'title' => 'Контролер',
					'cell' => 'C'
				),
				array(
					'title' => 'Час',
					'cell' => 'D'
				),
				array(
					'title' => 'Статус',
					'cell' => 'E'
				),
				array(
					'title' => 'Зона',
					'cell' => 'F'
				),
				array(
					'title' => 'Ряд',
					'cell' => 'G'
				),
				array(
					'title' => 'Місце',
					'cell' => 'H'
				),
				array(
					'title' => 'Ціна',
					'cell' => 'I',
				),
				array(
					'title' => 'Запрошення',
					'cell' => 'J'
					),
				array(
					'title' => 'Продавець',
					'cell' => 'K'
					),
				array(
					'title' => 'Групи зон',
					'cell' => 'L'
				),
				array(
					'title' => 'Коментар',
					'cell' => 'M'
				)
			];

			return $titles;
		}

		function get_barcodesbase_for_excel($event_id){
			$base_mass = Array();
			$count = 0;
			$sql = "SELECT e.id as 'id', z.sector as 'zone', z.id as 'zone_id', e.row as 'row', e.col as 'col', e.price as 'price', e.barcode as 'barcode', CASE WHEN e.status = 0 THEN 'Не зайшов' WHEN e.status = 1 THEN 'У залі' ELSE e.status END AS 'status', e.status as 'stat' FROM eventplace e LEFT JOIN zone z ON z.id = e.zone WHERE e.event = {$event_id}";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){

					$base_mass[$count]['id'] = $row['id'];
					$base_mass[$count]['barcode'] = $row['barcode'];
					$base_mass[$count]['status'] = $row['status'];
					$base_mass[$count]['zone'] = $row['zone'];
					$base_mass[$count]['row'] = $row['row'];
					$base_mass[$count]['col'] = $row['col'];
					$base_mass[$count]['price'] = $row['price'];
					$base_mass[$count]['zone_id'] = $row['zone_id'];

					if($row['stat'] == 1){
						$base_mass[$count]['time'] = $this->get_inhall_last_time($row['barcode'], $event_id);
					}else{
						$base_mass[$count]['time'] = '0000-00-00 00:00:00';
					}

					/*$log_mass[$count]['comment'] = $row['comment'];*/
					$count ++;
				}
				 $result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			return $base_mass;
		}

		function clear_scanlog($event_id){
			$status = $this->mysqli->query("DELETE FROM scanlog s WHERE s.event = {$event_id}");
			if($status == 1){
				return 'Лог видалено!';
			}else{
				return 'Помилка при видаленні логу!';
			}

		}


		function get_log_for_excel($event_id){
			$event = new Event();
			$user = new User();
			$saler = new Saler();
			$scanstatus = new Scanstatus();
			$log_mass = Array();
			$count = 0;

			if($event->get_addon_event($event_id) == 1){
				//echo "addon 1";
				$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'ctrl', s.time as 'time', s.status as 'status', z.sector as 'zone', z.id as 'zone_id', e.row as 'row', e.col as 'col', e.price as 'price', a.is_inv as 'inv', a.saler as 'saler', a.group_zone as 'groupz', a.comment as 'comment' FROM scanlog s LEFT JOIN eventplace e ON e.id = s.eventplace LEFT JOIN users u ON u.id = s.user LEFT JOIN zone z ON z.id = e.zone LEFT JOIN addon a ON a.barcode = e.barcode WHERE s.event = {$event_id}";
			}

			if($event->get_addon_event($event_id) == 0){
				//echo "addon 0";
				$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'ctrl', s.time as 'time', s.status as 'status', z.sector as 'zone', z.id as 'zone_id', e.row as 'row', e.col as 'col', e.price as 'price' FROM scanlog s LEFT JOIN eventplace e ON e.id = s.eventplace LEFT JOIN users u ON u.id = s.user LEFT JOIN zone z ON z.id = e.zone WHERE s.event = {$event_id}";
			}


			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){

					$log_mass[$count]['id'] = $row['id'];
					$log_mass[$count]['barcode'] = $row['barcode'];
					$log_mass[$count]['ctrl'] = $user->get_login_by_id($row['ctrl']);
					$log_mass[$count]['time'] = $row['time'];
					$log_mass[$count]['status'] = $scanstatus->get_status_name($row['status']);
					$log_mass[$count]['zone'] = $row['zone'];
					$log_mass[$count]['zone_id'] = $row['zone_id'];
					$log_mass[$count]['row'] = $row['row'];
					$log_mass[$count]['col'] = $row['col'];
					$log_mass[$count]['price'] = $row['price'];
					$log_mass[$count]['inv'] = $row['inv'];
					$log_mass[$count]['saler'] = $saler->get_saler_name(intval($row['saler']));
					/*$log_mass[$count]['comment'] = $row['comment'];*/
					$count ++;
				}
				 $result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			return $log_mass;

		}

		function get_log_status_count($status, $active_event_id, $user_id = 0){
			$log_count = 0;
			$query = '';

			if($user_id == 0){
				$query = 's.event ='.$active_event_id.' AND s.status = '.$status;
			}else{
				$query = ' s.status = '.$status.' AND s.user ='.$user_id;
			}

			$sql = "SELECT s.status as 'status', count(s.id) as 'scount' FROM scanlog s WHERE {$query} GROUP BY s.status";
			$result = $this->mysqli->query($sql);
			foreach($result as $row)
				$log_count = $row['scount'] ;

			return $log_count;
		}

		function insert_row($event, $eventplace_id, $barcode, $status, $user){
			$this->mysqli->query("INSERT INTO scanlog (`id`,`event`, `eventplace`, `barcode`, `time`, `status`, `user`) VALUES (NULL, {$event},{$eventplace_id},'{$barcode}', NOW(), {$status}, {$user})");
		}

		function get_time($eventplace_id){
			$time = '2022-01-01 00:00:00';
			$sql = "SELECT s.time as 'time' FROM scanlog s WHERE s.eventplace = {$eventplace_id} AND s.status = 1";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row)
					$time = $row["time"];
				 //$result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			return $time;
		}

		function get_inhall_last_time($barcode, $event){
			$time = '2022-01-01 00:00:00';
			$sql = "SELECT s.time as 'time' FROM scanlog s WHERE s.status = 1 AND s.event = {$event} AND s.barcode LIKE '{$barcode}' ORDER BY s.time DESC LIMIT 1";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row)
					$time = $row["time"];
				 //$result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			return $time;
		}


		function get_repit($eventplace_id){
			$repit = '';
			$count = 1;
			$last = false;

			$sql = "SELECT s.time as 'time' FROM scanlog s WHERE s.eventplace = {$eventplace_id} AND s.status = 2 LIMIT 4";
			if($result = $this->mysqli->query($sql)){

				$rowsCount = $result->num_rows;

				foreach($result as $row){
					if($count == $rowsCount){
						$last = true;
					}

					if(!$last)
						$repit .= $row["time"]."#";
					else
						$repit .= $row["time"];

					$count++;
				}

				 //$result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			return $repit;
		}

		function get_log_place($place_id){
			$stat = new Scanstatus();
			$user = new User();

			$log_place = "";

			$sql = "SELECT z.sector as 'sector', p.row as 'row', p.col as 'col' FROM eventplace p LEFT JOIN zone z ON z.id = p.zone WHERE p.id = {$place_id}";


			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
						$log_place .= $row["fan"]."<div style='margin:10px; font-weight:bold;'>Зона: ".$row["sector"]." Ряд - ".$row["row"]." Місце - ".$row["col"]."</div>";
				}
				 //$result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}

			$log_place .= "<div class='table-responsive'>
                    <table class='table table-striped table-borderless'>";
			$log_place .= '<th>Статус</th><th>Час</th><th>Контролер</th>';

			//$stat->get_status_name();
			//$user->get_login_by_id($user_id);

			$sql2 = "SELECT s.status as 'status', s.barcode as 'barcode', s.time as 'time', s.user as 'user' FROM scanlog s WHERE s.eventplace = {$place_id}";
			if($result2 = $this->mysqli->query($sql2)){
				foreach($result2 as $row2){
					$log_place .= '<tr><td style="background-color:'.$stat->get_status_color($row2["status"]).'">'.$stat->get_status_name($row2["status"])."</td><td style='background-color:".$stat->get_status_color($row2["status"])."'>".$row2["time"]."</td><td style='background-color:".$stat->get_status_color($row2["status"])."'>".$user->get_login_by_id($row2["user"])."</td></tr>";
				}
				 //$result->free();
			}else{
				echo "Ошибка: " . $mysqli->error;
			}
			$log_place .= "</table>";
			return $log_place;
		}

		function get_dates_scan($event){
			$dates = Array();

			$sql = "SELECT DATE(s.time) as 'date' FROM scanlog s WHERE s.event = {$event} GROUP BY date ORDER BY date";

			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
					$dates[] = $row['date'];
				}

				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $dates;
		}

	}//***Scanlog

	class Groupzone extends connection_bd{
		function get_group_name($group_id){
			$group_name = '';
			$sql = "SELECT g.name as 'name' FROM group_name g WHERE g.id = {$group_id};";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$group_name = $row['name'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $group_name;
		}

	}//*** Groupzone


	class Stat extends connection_bd{

		public $total = Array();
		public $inzone = Array();
		public $byhour = Array();
		public $byminint = Array();
		public $byusers = Array();
		public $byprice = Array();

		function get_total($event){
			$sql = "SELECT COUNT(e.id) as 'id' FROM eventplace e WHERE e.event = {$event};";
			if($result = $this->mysqli->query($sql)){

				foreach($result as $row){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
					$this->total['total'] = $row['id'];
				}

			}
			$inhall = 0;
			$inzone = $this->get_inzone_count($event);
			for($i=0; $i < count($inzone); $i++){
				$inhall += $inzone[$i]['inzone'];
			}
			$this->total['inhall'] = $inhall;

			return $this->total;
		}

		function get_by_price_inzone($event){
			$sql = "SELECT e.price as 'price', count(e.id) as 'count' FROM eventplace e WHERE e.event = {$event} and e.status=1 GROUP BY e.price ORDER BY e.price DESC;";
			if($result = $this->mysqli->query($sql)){
				$rowsCount = 0;
				foreach($result as $row){
					$this->byprice[$rowsCount]['price'] = $row['price'];
					$this->byprice[$rowsCount]['count'] = $row['count'];
					$rowsCount++;
				}
			}

			return $this->byprice;
		}

		function get_by_price_notinzone($price, $event){
			$sql = "SELECT count(e.id) as 'count' FROM eventplace e WHERE e.price = {$price} AND e.event = {$event} AND e.status=0;";
			$count = 0;
			if($result = $this->mysqli->query($sql)){
				$rowsCount = 0;
				foreach($result as $row){
					$count = $row['count'];
				}
			}

			return $count;
		}

		function get_inzone_count($event){
			$sql = "SELECT z.id as 'id', z.sector as 'sector', COUNT(e.id) as 'inzone_count' FROM eventplace e JOIN zone z ON z.id = e.zone WHERE e.event = {$event} AND e.status = 1 GROUP BY z.id ORDER BY z.id;";
			if($result = $this->mysqli->query($sql)){
			    $rowsCount = 0;
				foreach($result as $row){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
					$this->inzone[$rowsCount]['zone_id'] = $row['id'];
					$this->inzone[$rowsCount]['zonename'] = $row['sector'];
					$this->inzone[$rowsCount]['inzone'] = $row['inzone_count'];
					$rowsCount++;
				}

			}
			return $this->inzone;
		}

		function get_inzone_count_by_user($user, $zone){
			$count = 0;
			$sql = "SELECT count(s.id) as 'count' FROM scanlog s INNER JOIN eventplace e ON s.eventplace = e.id WHERE s.user = {$user} AND s.status = 1 AND e.zone = {$zone}";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
					$count = $row['count'];
				}

				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $count;
		}

		function get_zone_count($event, $zone_id){
			$zone_cnt = 0;
			$sql = "SELECT COUNT(e.id) as 'zone_count' FROM eventplace e WHERE e.event = {$event} AND e.zone = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
					$zone_cnt = $row['zone_count'];
				}
			}
			return $zone_cnt;
		}

		function get_count_by_hour($event){
			$sql = "SELECT hour(s.time) as 'time', count(s.id) as 'count' FROM scanlog s WHERE s.event = {$event} AND s.status = 1 GROUP BY hour(s.time) ORDER BY time";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->byhour[$row['time']] = $row['count'];
				}

			}

			return $this->byhour;
		}

		function get_time_interval($time1, $time2, $event){
			$count = 0;
			$sql = "SELECT count(s.id) as 'count' FROM scanlog s WHERE s.time BETWEEN '{$time1}' AND '{$time2}' AND s.event = {$event} AND s.status = 1";
			//echo $sql."<br/>";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
					$count = $row['count'];
				}

				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $count;
		}

		function get_event_duration($event_id){
			$event = new Event();
			$intr_min = 0;
			$min = $event->get_min_time($event_id);
			$max = $event->get_max_time($event_id);
			$sql = "SELECT ( UNIX_TIMESTAMP('{$max}') - UNIX_TIMESTAMP('{$min}') ) / 60 as 'interval'";

			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
					$intr_min = $row['interval'];
				}

				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			$intr_min = round($intr_min,0);

			$hours = intdiv($intr_min, 60);
			$min = $intr_min - $hours*60;

			if($hours == 0){
				return "Тривалість сканування: ".$min." хв.";
			}elseif($min == 0){
				return "Тривалість сканування: ".$hours." год.";
			}else{
				return "Тривалість сканування: ".$hours." год. ".$min." хв.";
			}

		}

		function get_count_by_min($event_id){
			$hours = $this->get_count_by_hour($event_id);
			$scan = new Scanlog();

			//$date = date('Y-m-d', strtotime($event->get_event_date($event_id)));
			$count = 0;
			foreach($scan->get_dates_scan($event_id) as $date){
				//echo $date."<br/>";
				foreach($hours as $k=>$v){
					for($i = 0 ; $i<60 ; $i+=5){
						if(strlen($i) == 1){
							if($i == 0){
								$time1 = $date." ".$k.':00:00';
								$time2 = $date." ".$k.':05:59';
								$interval = $k.':00 - '.$k.':05';
							}else{
								$time1 = $date." ".$k.':06:00';
								$time2 = $date." ".$k.':10:59';
								$interval = $k.':06 - '.$k.':10';
							}

						}else{
							$time1 = $date." ".$k.':'.($i+1).':00';
							$time2 = $date." ".$k.':'.($i+5).':59';
							$interval = $k.':'.($i+1).' - '.$k.':'.($i+5);
						}

						//echo $time1.' - '.$time2.' - '.$this->get_time_interval($time1,$time2,$event_id).'<br/>';
						//echo $this->get_time_interval($time1, $time2, $event_id);
						$this->byminint[$date][$interval] = $this->get_time_interval($time1, $time2, $event_id);

					}
						/*if ($i%10){
							echo $k.':'.$i+1)." - ".($i+5)."<br/>";
						}*/
				}
				$count++;
			}
			/*echo "<pre>";
			var_dump($this->byminint);
			echo "</pre>";*/

			return $this->byminint;
			/*
			$sql = "SELECT hour(s.time) as 'time', count(s.id) as 'count' FROM scanlog s WHERE s.event = {$event} AND s.status = 1 GROUP BY hour(s.time) ORDER BY time";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->byhour[$row['time']] = $row['count'];
				}

			}

			return $this->byhour;*/
		}

		function get_count_by_users($event){
			$sql = "SELECT s.user as 'user', count(s.id) as 'count' FROM scanlog s WHERE s.event = {$event} AND s.status = 1 GROUP BY s.user";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->byusers[$row['user']] = $row['count'];
				}

			}

			return $this->byusers;
		}

	}//****class Stat

	class MobApp extends connection_bd{

		private $err1 = 'Error: Подія не встановлена';
		private $err2 = 'Error: Квиток відсутній у базі даних';
		private $err3 = 'Error: Повторний вхід';
		private $err4 = 'Error: Скан на вихід. Квитка немає в залі';
		private $err5 = 'Error: Не та зона входу';

		private $resp1 = 'Вхід дозволено';
		private $resp2 = 'Вийшов із залу';

		function get_response_error($num){
			switch($num){
				case 1:
					return $this->err1;
					break;

				case 2:
					return $this->err2;
					break;

				case 3:
					return $this->err3;
					break;

				case 4:
					return $this->err4;
					break;

				case 5:
					return $this->err5;
					break;
			}
		}

		function get_response_succes($num){
			switch($num){
				case 1:
					return $this->resp1;
					break;

				case 2:
					return $this->resp2;
					break;
			}
		}

	}//***class MobApp

	class Eventplace extends connection_bd{

		public $id;
		public $zone_name;
		public $zone_id;
		public $barcode;
		public $row;
		public $col;
		public $price;
		public $status;
		public $event_id;


		function get_place_status_array($event){

			$stat_mass = Array();
			$sql = "SELECT e.id as 'eid', e.row as 'row', e.col as 'col', e.status as 'status', e.zone as 'zone', e.barcode as 'code' FROM eventplace e WHERE e.event = {$event}";
			if($result = $this->mysqli->query($sql)){
			   foreach($result as $row){
					$stat_mass[$row['zone']][$row['row']][$row['col']] = $row['eid']."#".$row['status']."#".$row['code'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $stat_mass;
		}

		function get_place_status($event, $zone, $row, $col){
			$sql = "SELECT e.id as 'eid', e.row as 'row', e.col as 'col', e.status as 'status', e.barcode as 'barcode' FROM eventplace e WHERE e.event = {$event} AND e.zone = {$zone} AND e.row = {$row}  AND e.col = {$col}";
			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
				if($rowsCount != 0){
			    	foreach($result as $row){
						$this->id = $row['eid'];
				 		$this->row = $row['row'];
				 		$this->col = $row['col'];
				 		$this->status = $row['status'];
				 		$this->barcode = $row['barcode'];
					}
				}else{
					return false;
					exit;
				}

				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			if($this->status == 1){
				return true;
			}

			if($this->status == 0){
				return false;
			}

		}

		function get_place($event, $barcode){


			if(strlen($barcode) == 1){

				$repl = array('%', '?', '\\');
				$barcode = str_replace($repl, '#', $barcode);
			}


			$sql = "SELECT e.id as 'eid', z.id as 'zid', z.sector as 'sector', e.row as 'row', e.col as 'col', e.barcode as 'barcode', e.event as 'event', e.status as 'status', e.price as 'price' FROM eventplace e JOIN zone z ON z.id = e.zone WHERE e.event = {$event} AND e.barcode LIKE '{$barcode}'";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows; // количество полученных строк
    			//echo "<p>Получено объектов: $rowsCount</p>";
    			if($rowsCount != 0){
    				 foreach($result as $row){
				 		$this->id = $row['eid'];
				 		$this->zone_name = $row['sector'];
				 		$this->zone_id = $row['zid'];
				 		$this->row = $row['row'];
				 		$this->col = $row['col'];
				 		$this->price = $row['price'];
				 		$this->status = $row['status'];
				 		$this->barcode = $row['barcode'];
				 		$this->event_id = $event;
				 	}
				 	return true;
    			}else{
    				return false;
    			}
			}else{
				return false;
			}

		}

		function get_group_zone($event, $barcode){
			$group_zone = 0;
			$sql = "SELECT a.group_zone as 'group' FROM addon a WHERE a.event = {$event} AND a.barcode LIKE '{$barcode}'";
			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
			    foreach($result as $row){
				 	$group_zone = $row['group'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $group_zone;
		}

		function get_is_attr($event_id, $barcode, $attr){//$attr: 1 - is_inv, 2 - sel_img
			$is_inv = 0;
			$sel_img = '';
			$sql = "SELECT a.is_inv as 'inv', s.img as 'img' FROM addon a LEFT JOIN saler s ON a.saler = s.id WHERE a.event = {$event_id} AND a.barcode LIKE '{$barcode}'";
			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
			    foreach($result as $row){
				 	$is_inv = $row['inv'];
				 	$sel_img = $row['img'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			if($attr == 1)
				return $is_inv;
			if($attr == 2)
				return $sel_img;
		}

		function is_fan($zone_id){
			$is_fan = 0;
			$sql = "SELECT z.is_fan as 'is_fan' FROM zone z WHERE z.id = {$zone_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$is_fan = $row['is_fan'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $is_fan;
		}

		function get_json($status, $user_id){

			$log = new Scanlog();
			$user = new User();
			$zone = new Zone();
			$event = new Event();

			if($status != 0){
				return '[{"status":'.$status.', "zone":"'.$this->zone_name.'", "zone_id":'.$this->zone_id.', "row":'.$this->row.',"col":'.$this->col.',"price":'.$this->price.',"time":"'.$log->get_time($this->id).'","repit":"'.$log->get_repit($this->id).'", "barcode":"'.$this->barcode.'","inv":'.$this->get_is_attr($this->event_id, $this->barcode, 1).',"img":"'.$this->get_is_attr($this->event_id, $this->barcode, 2).'", "fan":'.$this->is_fan($this->zone_id).', "lenta":"'.$zone->get_lenta($this->zone_id).'", "zaudio":"'.$zone->get_audio($this->zone_id).'", "user_count":"'.$user->get_count_by_id($user_id, $event->get_active_event_id()).'"}]';
			}else{
				return '[{"status":0}]';
			}

			/*if(isset($this->id)){
				if($time){
					$log = new Scanlog();
					return '[{"zone":"'.$this->zone_name.'", "zone_id":'.$this->zone_id.', "row":'.$this->row.',"col":'.$this->col.',"price":'.$this->price.',"time":"'.$log->get_time($this->id).'","barcode":"'.$this->barcode.'","inv":'.$this->get_is_attr($this->event_id, $this->barcode, 1).',"img":"'.$this->get_is_attr($this->event_id, $this->barcode, 2).'", "fan":'.$this->is_fan($this->zone_id).'}]';
				}else{
					return '[{"zone":"'.$this->zone_name.'", "zone_id":'.$this->zone_id.', "row":'.$this->row.',"col":'.$this->col.',"price":'.$this->price.',"time":"2022-01-01 00:00:00","barcode":"'.$this->barcode.'","inv":'.$this->get_is_attr($this->event_id, $this->barcode, 1).',"img":"'.$this->get_is_attr($this->event_id, $this->barcode, 2).'", "fan":'.$this->is_fan($this->zone_id).'}]';
				}
			}else{
				return 'Місце не визначено!!';
			}*/
		}

		function set_status($status, $eventplace_id){
			$this->mysqli->query("UPDATE eventplace e SET e.status = {$status} WHERE e.id = {$eventplace_id}");
		}

		function get_unsold_tickets($event_id){

			$unsold_mass = Array();
			$count = 0;

			$sql = "SELECT z.id as 'zone_id', z.sector as 'name', e.row as 'row', e.col as 'col', e.price as 'price', e.barcode as 'barcode' FROM eventplace e LEFT JOIN zone z ON z.id = e.zone WHERE e.status = 0 AND e.event = {$event_id}";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$unsold_mass[$count]['zone_id'] = $row['zone_id'];
					$unsold_mass[$count]['name'] = $row['name'];
					$unsold_mass[$count]['row'] = $row['row'];
					$unsold_mass[$count]['col'] = $row['col'];
					$unsold_mass[$count]['price'] = $row['price'];
					$unsold_mass[$count]['barcode'] = $row['barcode'];
					$count++;
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $unsold_mass;

		}

		function add_tickets($ticket_mass, $zone, $event_id){
			$validation = new Validation();
			$count = 0;
			foreach($ticket_mass as $k=>$barcode){
				$barcode = $validation->text_validation($barcode);
				$barcode = trim($barcode);
				if($result = $this->mysqli->query("INSERT INTO eventplace (`id`, `event`, `zone`, `row`, `col`, `price`, `barcode`, `status`) VALUES (NULL, '{$event_id}', '{$zone}', '1', '1', '1', '{$barcode}', '0')")){

							//echo 'The ID is: '.$this->mysqli->insert_id."<br/>";
					$count++;
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}
			}

			return $count;
		}


	}//***Eventplace



	class Hall extends connection_bd{

			public $event_id;
			public $name;
			public $addr;
			public $img;
			public $viewbox;
			public $scale;
			public $x;
			public $y;

			function __construct($event_id){

				parent::__construct();

				$this->event_id = $event_id;

				$sql = "SELECT h.name as 'hall_name', h.adress as 'hall_addr', h.img as 'img', h.viewbox as 'viewbox', h.scale as 'scale', h.x as 'x', h.y as 'y' FROM hall h INNER JOIN event e ON e.hall = h.id  WHERE e.id = {$event_id} AND e.Deleted = 0";
				if($result = $this->mysqli->query($sql)){
				    foreach($result as $row){
					 	$this->name = $row['hall_name'];
					 	$this->addr = $row['hall_addr'];
					 	$this->img = $row['img'];
					 	$this->viewbox = $row['viewbox'];
						$this->scale = $row['scale'];
						$this->x = $row['x'];
						$this->y = $row['y'];
					}
					$result->free();
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}

  			}

  			function get_hall_name_by_id($hall_id){

  				$hname = '';

  				$sql = "SELECT h.name as 'hall_name' FROM hall h WHERE h.id = {$hall_id}";

  				if($result = $this->mysqli->query($sql)){
				    foreach($result as $row){
					 	$hname = $row['hall_name'];
					}
					$result->free();
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}

				return $hname;

  			}

  			function get_zones_table_by_id($hall_id){
  				$zone = new Zone();
  				$zone_tbl = '';

  				$sql = "SELECT z.id as 'zid', z.sector as 'zname', count(h.id) as 'count', z.img as 'img', z.audio as 'audio' FROM zone z JOIN hallplace h ON z.id = h.zone WHERE z.hall = {$hall_id} GROUP BY z.id";



  				$zone_tbl .= '<div class="table-responsive"><table class="table" style="width: 70%;">';

                switch(Settings::GetLang()){

			      	case 'ukr':
		                $zone_tbl .=  '<thead><th style="font-size:20px;">ID</th><th style="font-size:20px;">Назва зони</th><th style="font-size:20px; text-align:center;">Кілікість місць</th><th style="font-size:20px;">Стрічка</th><th style="font-size:20px;">Аудіо</th></thead><tbody>';

		            break;

					case 'eng':
					    $zone_tbl .=  '<thead><th style="font-size:20px;">ID</th><th style="font-size:20px;">Zone name</th><th style="font-size:20px; text-align:center;">Place count</th><th style="font-size:20px;">Ribbon</th><th style="font-size:20px;">Audio</th></thead><tbody>';

		            break;

				}



                //$zone_tbl .= '<tr><td>64</td><td>Партер</td><td>105</td><td><img src="/img/lentas/red.jpg"/></td></tr></tbody></table>';


  				if($result = $this->mysqli->query($sql)){
				    foreach($result as $row){
						$zone_tbl .= '<tr><td>'.$row['zid'].'</td><td>'.$row['zname'].'</td>';

						if($zone->is_fan($row['zid']) == 1){
							$zone_tbl .= '<td>FAN</td>';
						}else{
							$zone_tbl .= '<td>'.$row['count'].'</td>';
						}

						if($row['img'] != ''){
							$zone_tbl .= '<td><img style="border-radius:unset; width:100%; height:100%;" src="'.$row['img'].'"/></td>';
						}else{
							$zone_tbl .= '<td>-</td>';
						}

						if(!empty($row['audio'])){
							$path = '"'.$row['audio'].'"';
							$zone_tbl .= "<td><a href='#' onclick='play_audio(".$path.")'><i class='mdi icon-md mdi-volume-high'></i></a></td>";
						}

						$zone_tbl .= "</tr>";
					}
				}else{
						echo "Ошибка: " . $this->mysqli->error;
				}

				$result->free();

                return $zone_tbl;
  			}

  			function add_hall($name, $addr, $viewbox, $scale){

				//$forlog = $name."_(".str_replace(':',"_", $date).")";
				//$name = $name." (".date('d.m.Y H:i',strtotime($date)).")";

				//echo $name." / ".$forlog." / ".$date." / ".$hall." / ".$addon." / ".$importbarcodes."<br/>";

				return $this->mysqli->query("INSERT INTO `hall` (`id`, `name`, `adress`, `img`, `viewbox`, `scale`, `x`, `y`) VALUES (NULL, '{$name}', '{$addr}', '','{$viewbox}', {$scale}, 0, 0)");

			}

  			function get_csv_str_table_hall(){
				$csv_tbl = '';

				switch(Settings::GetLang()){

			      	case 'ukr':

						$csv_tbl .= '<h3>Структура csv файлу</h3>';

						$csv_tbl .= '<table class="table table-dark"><tr><th>Зона (ID)</th><th>X</th><th>Y</th><th>Width</th><th>Height</th><th>Ряд</th><th>Місце</th><th>Текст</th></tr><tr><th>74</th><th>576</th><th>159</th><th>30</th><th>30</th><th>21</th><th>10</th><th>"21"</th></tr></table>';
					break;

					case 'eng':

						$csv_tbl .= '<h3>csv file structure</h3>';

						$csv_tbl .= '<table class="table table-dark"><tr><th>Zone (ID)</th><th>X</th><th>Y</th><th>Width</th><th>Height</th><th>Row</th><th>Place</th><th>Text</th></tr><tr><th>74</th><th>576</th><th>159</th><th>30</th><th>30</th><th>21</th><th>10</th><th>"21"</th></tr></table>';
					break;


				}


				return $csv_tbl;
			}

			//Получить список залов
			function get_halls_select(){
				$hall_html = '';
				$sql = "SELECT * FROM hall h";
				$hall_html .= "<select name='halls' id='halls' class='js-example-basic-single w-100' style='float:left; width:50%;'>";

				switch(Settings::GetLang()){
					case 'ukr':
						$hall_html .= "<option value='-1'>Вибрати площадку</option>";
					break;

					case 'eng':
						$hall_html .= "<option value='-1'>Select location</option>";
					break;
				}


				if($result = $this->mysqli->query($sql)){
				    foreach($result as $row){
						 $hall_html .= "<option  value='".$row['id']."'>".$row['name']."</option>";
					}
					$result->free();
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}
				$hall_html .= "</select>";
				return $hall_html;
			}//****Получить список залов


  			//Импорт мест в зале
			function import_hallplace_from_csv(){
				if(!empty($_FILES['hall_file']['tmp_name'])){
					$f=fopen($_FILES['hall_file']['tmp_name'], 'rb');
					if(!$f) die('error opening file');
						while($row=fgetcsv($f, 128,';')){
							if($this->mysqli->query("INSERT INTO hallplace (`id`, `zone`, `x`, `y`,`width`, `height`, `row`, `col`, `text`) VALUES (NULL, '{$row[0]}', '{$row[1]}', '{$row[2]}', '{$row[3]}', '{$row[4]}','{$row[5]}','{$row[6]}', '{$row[7]}')")){
								echo "Місце додане: ";
							}
							else{
								echo "Ошибка: " . $this->mysqli->error;
							}


				  			echo addslasheS($row[0])." ".addslasheS($row[1])." ".addslashes($row[2])." ".addslashes($row[3])." ".addslashes($row[4])." ".addslashes($row[5]).'<br />';

					   }
				  	fclose($f);
				}
			}//***Импорт мест в зале


  			function get_svg_hall_map($hall_id = 0){

  				$zone = new Zone();
  				$place = new Eventplace();
  				$set = new Settings();
  				$status_arr = $place->get_place_status_array($this->event_id);

  				$hall_map = "";
  				$empty_map = 0;

  				/*$sql = "SELECT z.id as 'zid', h1.name as 'hall_name', z.sector as 'sector_name', e.id as 'eid', e.row as 'row', e.col as 'col', e.status as 'status', e.barcode as 'barcode', h.x as 'cx', h.y as 'cy', h.width as 'width', h.height as 'height', h.text as 'text' FROM hallplace h LEFT JOIN eventplace e ON (h.zone = e.zone AND h.row = e.row AND h.col = e.col) LEFT JOIN zone z ON h.zone = z.id LEFT JOIN hall h1 ON h1.id = z.hall WHERE z.is_fan = 0 AND e.event = {$this->event_id}";*/

  				if($hall_id == 0){
  					$query = "h.zone IN ({$zone->get_zones_ids($this->event_id)})";
  				}else{
  					$query = "z.hall = {$hall_id}";
  				}

  				$sql = "SELECT z.id as 'zid', h.row as 'row', h.col as 'col', h.x as 'cx', h.y as 'cy', h.width as 'width', h.height as 'height', h.text as 'text' FROM hallplace h JOIN zone z ON z.id= h.zone WHERE z.is_fan = 0 AND {$query}";


				/*echo $this->event_id."<br/>";
				echo $sql."<br/>";
				echo $zone->get_zones_ids($this->event_id)."<br/>";*/

				//Рендер обычного места
				if($result = $this->mysqli->query($sql)){
					$rowsCount = $result->num_rows;
					if($rowsCount == 0){
						$empty_map = 1;
					}

					$hall_map .= '<div style="backface-visibility: hidden; transform: scale3d(';

					if ($this->scale != 0){
						$hall_map .= $this->scale.",".$this->scale.",".$this->scale;
					}else{
						$hall_map .= "3.5, 3.5, 3.5";
					}

					$hall_map .='); filter: blur(0px); margin-top: 335px; margin-left: 120px;" >
<svg xmlns="https://www.w3.org/200/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="'.$this->viewbox.'" class="active">
<image xlink:href="'.$this->img.'" x="'.$this->x.'" y="'.$this->y.'" onerror="this.style.display = "none"></image>';

					$hall_map .= "<style> .place{fill:#fff; font-family: Calibri, Arial, Tahoma, Verdana, sans-serif;} .cur_p{cursor:pointer;}</style>";
					$hall_map .= "<g id='places'>";

				    foreach($result as $row){

				    	/*if(isset($status_arr[$row['zid']][$row['row']][$row['col']])){
				    		$p = explode("#", $status_arr[$row['zid']][$row['row']][$row['col']]);
							echo $p[0]." - ".$p[1]."<br/>";
				    	}else{
				    		echo "NOT SET!!";
				    	}*/
				    	//$place = new Eventplace();

				    	//$hall_map .= $place->id." ".$place->row." ".$place->col." ".$place->status." ".$place->barcode."<br/>";
				    	if(isset($status_arr[$row['zid']][$row['row']][$row['col']])){

				    		$p = explode("#", $status_arr[$row['zid']][$row['row']][$row['col']]); // $p[0] - place id, $p[1] - status, $p[2] - barcode

				    		$hall_map .= "<circle id='".$p[0]."' cx='".$row['cx']."' cy='".$row['cy']."' r='".($row['width']/2)."'";

					 		if($p[1] == 1){

					 			if ($place->get_is_attr($this->event_id, $p[2], 1) == 1 ){ // IF INV
					 				$hall_map .= " fill='#e01a52' ";
					 			}else{
					 				$hall_map .= " fill='#299cf4' ";
					 			}
					 		}

					 		if($p[1] == 0)
					 			$hall_map .= "fill='#888'";

					 		if($p[1] == 1){
					 			$hall_map .= 'onclick="showTooltip(evt, '."'".$p[0]."'".');" onmouseout="hideTooltip();"  class="cur_p"></circle>';
					 		}else{
					 			$hall_map .= ' class="cur_p"></circle>';
					 		}


					 		if (strlen($row['text']) == 1){
								$x = intval($row['cx'])-4;
					 			$y = intval($row['cy'])+4;
							}

							if (strlen($row['text']) == 2){
								$x = intval($row['cx'])-7;
					 			$y = intval($row['cy'])+4;
							}

							if (strlen($row['text']) == 3){
								$x = intval($row['cx'])-8;
					 			$y = intval($row['cy'])+4;
							}

					 		$hall_map .= "<text place='".$p[0]."' x='".$x."' y='".$y."' font-size='12' class='place cur_p'";

					 		if($p[1] == 1){
						 		$hall_map .=  'onclick="showTooltip(evt, '."'".$p[0]."'".');" onmouseout="hideTooltip();">'.$row['text'].'</text>';
						 	}else{
						 		$hall_map .=  '>'.$row['text'].'</text>';
						 	}

				    	}else{
							$hall_map .= "<circle id='".$row['zid']."' cx='".$row['cx']."' cy='".$row['cy']."' r='".($row['width']/2)."' fill='#888'class='cur_p'></circle>";

							if (strlen($row['text']) == 1){
								$x = intval($row['cx'])-4;
						 		$y = intval($row['cy'])+4;
							}

							if (strlen($row['text']) == 2){
								$x = intval($row['cx'])-7;
						 		$y = intval($row['cy'])+4;
							}

							if (strlen($row['text']) == 3){
								$x = intval($row['cx'])-8;
					 			$y = intval($row['cy'])+4;
							}

							$hall_map .= "<text place='".$row['eid']."' x='".$x."' y='".$y."' font-size='12' class='place cur_p'>".$row['text']."</text>";
				    	}
				    	/*
					 	$hall_map .= "<circle id='".$row['eid']."' cx='".$row['cx']."' cy='".$row['cy']."' r='".($row['width']/2)."'";

					 	if($row['status'] == 1){
					 		if ($place->get_is_attr($this->event_id, $row['barcode'], 1) == 1 ){
					 			$hall_map .= "fill='#e01a52'";
					 		}else{
					 			$hall_map .= "fill='#299cf4'";
					 		}
					 	}

					 	if($row['status'] == 0)
					 		$hall_map .= "fill='#888'";

					 	$hall_map .= 'onclick="showTooltip(evt, '."'".$row['eid']."'".');" onmouseout="hideTooltip();"  class="cur_p"></circle>';


						//$hall_map .= '<rect id="2077845347" x="695" y="706" width="700" height="300" fill="#E04891" style=""></rect>';

						if (strlen($row['text']) == 1){
							$x = intval($row['cx'])-4;
					 		$y = intval($row['cy'])+3;
						}

						if (strlen($row['text']) == 2){
							$x = intval($row['cx'])-6;
					 		$y = intval($row['cy'])+3;
						}

					 	$hall_map .= "<text place='".$row['eid']."' x='".$x."' y='".$y."' font-size='12' class='place cur_p'";


					 	$hall_map .=  'onclick="showTooltip(evt, '."'".$row['eid']."'".');" onmouseout="hideTooltip();">'.$row['text'].'</text>';

					 	*/
					}
					$result->free();
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}


				//Рендер фанки

				$sql2 = "SELECT z.id as 'zid', h.x as 'cx', h.y as 'cy', h.width as 'width', h.height as 'height', h.text as 'text' FROM hallplace h LEFT JOIN zone z ON h.zone = z.id LEFT JOIN hall h1 ON h1.id = z.hall LEFT JOIN event e ON e.hall = h1.id WHERE z.is_fan = 1 AND e.id = {$this->event_id}";

				if($result2 = $this->mysqli->query($sql2)){
					$rowsCount2 = $result2->num_rows;
					if($rowsCount2 == 0){
						if($empty_map == 1){
							$empty_map = 2;
						}
					}

					 foreach($result2 as $row2){
					 	$hall_map .= "<rect id='".$row2['zid']."' x='".$row2['cx']."' y='".$row2['cy']."' width='".$row2['width']."' height='".$row2['height']."'";

					 	if($zone->zone_place_count($row2['zid'], $this->event_id, 1) > 0){
					 		$hall_map .= " fill='#299cf4' ";
					 	}else{
							$hall_map .= " fill='#888' ";
					 	}

					 	$hall_map .= ' class="cur_p"></rect>';


					 	$hall_map .= "<text place='".$row2['zid']."' x='".($row2['cx']+20)."' y='".($row2['cy']+40)."' font-size='40' class='place cur_p'>".$row2['text'].'</text>';

					 	$all = $zone->zone_place_count($row2['zid'], $this->event_id, 1) + $zone->zone_place_count($row2['zid'], $this->event_id, 0);

					 	$hall_map .= "<text place='".$row2['eid']."' x='".($row2['cx']+20)."' y='".($row2['cy']+80)."' font-size='30' class='place cur_p'>У зоні: ".$zone->zone_place_count($row2['zid'], $this->event_id, 1)."</text>";

					 	if($all != 0 && $set->fan_procent == 1){
					 		$hall_map .= "<text place='".$row2['eid']."' x='".($row2['cx']+20)."' y='".($row2['cy']+120)."' font-size='30' class='place cur_p'>".round($zone->zone_place_count($row2['zid'], $this->event_id, 1)*100/$all,0) ."%</text>";
					 	}
					 }
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}

				$hall_map .= "</g>";
				$hall_map .= '</svg></div>';

				if($empty_map == 2){
					$hall_map = "Нема схеми залу !!!";
					return $hall_map;
				}

				return $hall_map;

  			}//*****get_svg_hall_map()


	}//***Hall

	class Scanstatus extends connection_bd{

		//Получить список статусов сканлога
		function get_status_select(){
			$set = new Settings();
			$stat_html = '';
			$sql = "SELECT * FROM `scanlog_status`";

			$stat_html .= "<span style='font-weight:bold; float:left; padding:0 5px;'>Status: </span><select name='status' id='status'>";
			$stat_html .= "<option value='-1'>All</option>";

			if($result = $this->mysqli->query($sql)){
				 foreach($result as $row){
				 	switch($set->lang){
			      		case 'ukr':
							$stat_html .= "<option style='' value='".$row['status']."'>".$row['name']."</option>";
						break;

						case 'eng':
							$stat_html .= "<option style='' value='".$row['status']."'>".$row['name_eng']."</option>";
						break;

					}
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			$stat_html .= "</select>";
			return $stat_html;
		}//****Получить список статусов сканлога

		function get_status_name($status){
			$name = '';
			$sql = "SELECT s.name as 'name' FROM scanlog_status s WHERE s.status = '{$status}'";
			if($result = $this->mysqli->query($sql)){
				 foreach($result as $row){
					$name = $row['name'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $name;
		}

		function get_status_color($status){
			$color = '';
			$sql = "SELECT s.color as 'color' FROM scanlog_status s WHERE s.status = '{$status}'";
			if($result = $this->mysqli->query($sql)){
				 foreach($result as $row){
					$color = $row['color'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $color;
		}


	}

	class Saler extends connection_bd{

		function get_saler_img($saler){
			$path = '';
			$sql = "SELECT s.img as 'path' FROM saler s WHERE s.id = '{$saler}'";
				if($result = $this->mysqli->query($sql)){
					foreach($result as $row){
						$path = $row['path'];
					}
					$result->free();
				}
				else{
					echo "Ошибка: " . $this->mysqli->error;
				}
			return $path;
		}

		function get_saler_name($saler){
			$sel_name = '';
			$sql = "SELECT s.name as 'name' FROM saler s WHERE s.id = {$saler}";
				if($result = $this->mysqli->query($sql)){
					foreach($result as $row){
						$sel_name = $row['name'];
					}
					$result->free();
				}
				else{
					echo "Ошибка: " . $this->mysqli->error;
				}
			return $sel_name;
		}
	}

	class Event extends connection_bd{

		private $active_event_name = '';
		private $active_event_id = 0;


		function get_event_name($event_id){
  			$event_name = '';
			$sql = "SELECT e.name as 'name' FROM event e WHERE e.id = {$event_id} AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
				 	$event_name = $row['name'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $event_name;
		}

		function is_addon_event($event_id){
  			$addon = 0;
			$sql = "SELECT e.addon as 'addon' FROM event e WHERE e.id = {$event_id} AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
				 	$addon = $row['addon'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $addon;
		}


  		function get_forlog_event_name($event_id){
  			$forlog_name = '';
			$sql = "SELECT e.forlog as 'forlog' FROM event e WHERE e.id = {$event_id} AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
				 	$forlog_name = $row['forlog'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $forlog_name;
		}

		function get_zones_ids_names($event){

			$zones_ids_names = '(';

			$sql = "SELECT z.id as 'zid', z.sector as 'zname' FROM event e JOIN hall h ON h.id=e.hall JOIN zone z ON z.hall = h.id WHERE e.id = {$event}";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;

			    foreach($result as $row){
				 	$zones[$row['zid']] = $row['zname'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			$count = 0;

			if( $rowsCount != 0){
				foreach($zones as $k=>$v){
					if($count != $rowsCount-1){
						$zones_ids_names .= $k." - ".$v." | ";
					}else{
						$zones_ids_names .= $k." - ".$v;
					}


					$count++;
				}
			}

			$zones_ids_names .= ')';

			return $zones_ids_names;

		}

		function get_csv_str_table($addon){
			$csv_tbl = '';
			$set = new Settings();
			/*$zones = Array();
			$e = intval($event);
			echo $e."<br/>";
			$sql = "SELECT z.id as 'zid', z.sector as 'zname' FROM event e JOIN hall h ON h.id=e.hall JOIN zone z ON z.hall = h.id WHERE e.id = {$e}";

			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row){
				 	$zones[$row['zid']] = $row['zname'];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			/*foreach($zones as $k=>$v){
				echo $k." - ".$v."<br/>";
			}*/

			/*echo "<pre>";
			var_dump($zones);
			echo "</pre>";*/

			//$csv_tbl .= '<h3 style="float:left; margin-right:10px;">Структура csv файлу</h3><span id="zone_ids" style="font-size:18px;"></span>';
			if ($addon){
				switch($set->lang){
			      case 'ukr':
			        $csv_tbl .= '<table class="table table-dark"><tr><th>Зона (ID)</th><th>Ряд</th><th>Місце</th><th>Ціна</th><th>Штрихкод</th><th>Запрошення</th><th>Продавець (ID)</th><th>Коментар</th></tr><tr><th>20</th><th>10</th><th>2</th><th>200</th><th>369796790950</th><th>0/1</th><th>10</th><th>Comment</th></tr></table>';
			        break;

			      case 'eng':
			        $csv_tbl .= '<table class="table table-dark"><tr><th>Zone (ID)</th><th>Row</th><th>Place</th><th>Price</th><th>Barcode</th><th>Invite</th><th>Saler (ID)</th><th>Comment</th></tr><tr><th>20</th><th>10</th><th>2</th><th>200</th><th>369796790950</th><th>0/1</th><th>10</th><th>test comment</th></tr></table>';
			        break;

			    }

			}else{
				switch($set->lang){
			      case 'ukr':
			        $csv_tbl .= '<table class="table table-dark"><tr><th>Зона (ID)</th><th>Ряд</th><th>Місце</th><th>Ціна</th><th>Штрихкод</th></tr><tr><th>20</th><th>10</th><th>2</th><th>200</th><th>369796790950</th><th></th></tr></table>';
			        break;

			      case 'eng':
			        $csv_tbl .= '<table class="table table-dark"><tr><th>Zone (ID)</th><th>Row</th><th>Place</th><th>Price</th><th>Barcode</th></tr><tr><th>20</th><th>10</th><th>2</th><th>200</th><th>369796790950</th><th></th></tr></table>';
			        break;
			     default:
			     	$csv_tbl .= '<table class="table table-dark"><tr><th>Зона (ID)</th><th>Ряд</th><th>Місце</th><th>Ціна</th><th>Штрихкод</th></tr><tr><th>20</th><th>10</th><th>2</th><th>200</th><th>369796790950</th><th></th></tr></table>';
			     break;

			    }
			}

			return $csv_tbl;
		}

		//Получить список мероприятий
		function get_events_select($id_name){
			$sel_html = '';
			$sql = "SELECT * FROM event e WHERE e.Deleted = 0";
			$sel_html .= "<select name='event' id='".$id_name."' class='js-example-basic-single w-100' style='float:left;'>";
			$sel_html .= "<option value='-1'>Вибрати подію</option>";
			if($result = $this->mysqli->query($sql)){
			    foreach($result as $row2){
				 	if($row2['IsActive']==1){
					 		$sel_html .= "<option selected value='".$row2['id']."'>".$row2['name']."</option>";
					 	}else{
					 		$sel_html .= "<option value='".$row2['id']."'>".$row2['name']."</option>";
					 	}
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			$sel_html .= "</select>";
			return $sel_html;
		}//****Получить список мероприятий

		//Импорт в базу шк
		function import_barcods_from_csv($event_id, $addon){
			$place = new Eventplace();
			$count = 0;
			if(!empty($_FILES['passed_file']['tmp_name'])){
				$f=fopen($_FILES['passed_file']['tmp_name'], 'rb');
				if(!$f) die('error opening file');
				while($row=fgetcsv($f, 128,';')){

					$barcode = trim($row[4]);

					if($place->is_fan($row[0])){
						$row[1] = 1;
						$row[2] = 1;
					}

					if($result = $this->mysqli->query("INSERT INTO eventplace (`id`, `event`, `zone`, `row`, `col`, `price`, `barcode`, `status`) VALUES (NULL, '{$event_id}', '{$row[0]}', '{$row[1]}', '{$row[2]}', '{$row[3]}', '{$barcode}', '0')")){

						//echo 'The ID is: '.$this->mysqli->insert_id."<br/>";
						$count++;
					}else{
						//echo "Ошибка: " . $this->mysqli->error;
					}

				  	if($addon){
				  		$this->mysqli->query("INSERT INTO addon (`id`, `barcode`, `event`, `is_inv`, `saler`, `group_zone`, `comment`) VALUES (NULL, '{$barcode}', '{$event_id}', '{$row[5]}', '{$row[6]}', 1, '{$row[7]}')");
				  		//echo $event_id." ".$row[0]." ".addslasheS($row[0])." ".addslasheS($row[1])." ".addslashes($row[2])." ".addslashes($row[3])." ".addslashes($row[4])." ".addslashes($row[5])." ".addslashes($row[6])." ".addslashes($row[7]).'<br />';
				  	}else{
					  //echo $event_id." ".$row[0]." ".addslasheS($row[0])." ".addslasheS($row[1])." ".addslashes($row[2])." ".addslashes($row[3])." ".addslashes($row[4])." ".'<br />';

					  // echo mysql_error();
					}
				}
				 fclose($f);
			}
			return $this->get_event_name($event_id)."(".$this->get_event_date($event_id).")"." Додано штрихкодів у базу - ".$count;
		}//***Импорт в базу шк

		//Для раздела "История ШК"
		function get_log_barcode($event_id, $barcode = ''){
			$log_table = 'Немає жодного запису!!';
			$sel = new Saler();
			$scanstatus = new Scanstatus();
			$zone = new Zone();
			$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'user', s.time as 'time', s.status as 'status', z.id as 'zone_id', z.sector as 'zone', e.row as 'row', e.col as 'col', e.price as 'price', a.is_inv as 'inv', a.saler as 'saler', g.name as 'g_zone', a.comment as 'comment' FROM scanlog s LEFT JOIN eventplace e ON s.eventplace = e.id LEFT JOIN zone z ON e.zone = z.id LEFT JOIN addon a ON a.barcode = e.barcode LEFT JOIN group_name g ON g.id=a.group_zone WHERE s.barcode LIKE '".$barcode."' AND s.event = ".$event_id." ORDER BY time";
			//echo $sql;
			if($result = $this->mysqli->query($sql)){
   					$rowsCount = $result->num_rows; // количество полученных строк
    				//echo "<p>Получено объектов: $rowsCount</p>";

    				if($rowsCount != 0){
    					$user = new User();
    					if($this->get_addon_event($event_id) == 1){
							$log_table = $this->get_table_head(1);
    					}else{
    						$log_table = $this->get_table_head(0);
    					}


						foreach($result as $row2){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
		      				// echo "<tr style='background-color: #fff;'><td>".$row2['id']."</td><td>".$row2['barcode']."</td><td>".$row2['user']."</td><td>".$row2['time']."</td><td>";

			   				$log_table .= $this->get_table_block($row2, $user->get_login_by_id($row2['user']), $scanstatus->get_status_name($row2['status']) ,$scanstatus->get_status_color($row2['status']), $zone->is_fan($row2['zone_id']));

							if($this->get_addon_event($event_id) == 1){
								if($row2['inv'] == 1){
									$log_table .= "<td>Так</td>";
								}else{
									$log_table .= "<td>Ні</td>";
								}

								if($sel->get_saler_img($row2['saler']) != ''){
									$log_table .= "<td><img src='".$sel->get_saler_img($row2['saler'])."' style='border-radius:0; width: 100%; height: 100%;' /></td><td>".$row2['comment']."</td></tr>";
								}else{
									$log_table .= "<td></td>";
								}
							}else{
								$log_table .="</tr>";
							}

						}

					   $log_table .= "</tbody></table>";
					   $result->free();
					}
				}else{
	    			echo "Ошибка: " . $this->mysqli->error;
				}

			return $log_table;

		}//***Для раздела "История ШК"

		function get_table_head($addon){//1 - шапка тблицы(addon); 2 - шапка тблицы

			$block = "";


			if($addon == 1){

				switch(Settings::GetLang()){
			    	case 'ukr':
				    	$block .= "<table class='table table-bordered'><thead><tr><th>Id</th><th>Штрихкод</th><th>Зона</th><th>Ряд</th><th>Місце</th><th>Ціна</th><th>Контролер</th><th>Час</th><th>Статус</th><th>Запрошення</th><th>Продавець</th><th>Коментар</th></tr></thead><tbody>";
				    break;

				    case 'eng':
				    	$block .= "<table class='table table-bordered'><thead><tr><th>Id</th><th>Barcode</th><th>Zone</th><th>Row</th><th>Place</th><th>Price</th><th>Controler</th><th>Time</th><th>Status</th><th>Invitation</th><th>Saler</th><th>Comment</th></tr></thead><tbody>";
				    break;
				 }

			}else{
				switch(Settings::GetLang()){
			    	case 'ukr':
						$block .= "<table class='table table-bordered'><thead><tr><th>Id</th><th>Штрихкод</th><th>Зона</th><th>Ряд</th><th>Місце</th><th>Ціна</th><th>Контролер</th><th>Час</th><th>Статус</th></tr></thead><tbody>";
				    break;

				    case 'eng':
				    	$block .= "<table class='table table-bordered'><thead><tr><th>Id</th><th>Barcode</th><th>Zone</th><th>Row</th><th>Place</th><th>Price</th><th>Controler</th><th>Time</th><th>Status</th></tr></thead><tbody>";
				    break;
				}
			}

			return $block;
		}

		function get_table_block($row, $user, $status, $color, $is_fan){
			$line = "";
			$line .= "<tr class='".$color."'>";
			$line .= "<td>".$row['id']."</td><td>".$row['barcode']."</td><td>".$row['zone']."</td>";

			if($is_fan == 0)
				$line .="<td>".$row['row']."</td><td>".$row['col']."</td>";

			if($is_fan == 1)
				$line .="<td></td><td></td>";

			$line .= "<td>".$row['price']."</td><td>".$user."</td><td>".$row['time']."</td><td>".$status."</td>";

			return $line;
		}



		//Получить таблицу лога входа для раздела "Лог"
		function get_log_table($event_id, $status, $barcode = ''){

			$sel = new Saler();
			$scanstatus = new Scanstatus();
			$zone = new Zone();
			//$set = new Settings();

			switch(Settings::GetLang()){
			      case 'ukr':
			      	$log_table = 'Нема жодного запису!!';
			      break;

			      case 'eng':
			      	$log_table = 'There is no record!!';
			      break;

			      default:
			      	$log_table = 'Нема жодного запису!!';
			      break;
			}


			$sql_go = false;
			if($barcode != ''){
				$sql_where = "s.barcode LIKE '".$barcode."'";
				$sql_go = true;
			}

			if($event_id != 0){
				$sql_where = "s.event = ". $event_id;
				$sql_go = true;
			}

			if($status != -1){
				$sql_where .= " AND s.status = ". $status;
			}

			if($sql_go){

				//$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'user', s.time as 'time', s.status as 'status', z.sector as 'zone', e.row as 'row', e.col as 'col', e.price as 'price' FROM scanlog s LEFT JOIN eventplace e ON s.eventplace = e.id LEFT JOIN zone z ON e.zone = z.id WHERE {$sql_where}";

				$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'user', s.time as 'time', s.status as 'status', z.id as 'zone_id',  z.sector as 'zone', e.row as 'row', e.col as 'col', e.price as 'price', a.is_inv as 'inv', a.saler as 'saler', g.name as 'g_zone', a.comment as 'comment' FROM scanlog s LEFT JOIN eventplace e ON s.eventplace = e.id LEFT JOIN zone z ON e.zone = z.id LEFT JOIN addon a ON a.barcode = e.barcode LEFT JOIN group_name g ON g.id=a.group_zone WHERE {$sql_where} ORDER BY time";

				//echo $sql;
				if($result = $this->mysqli->query($sql)){
   					$rowsCount = $result->num_rows; // количество полученных строк
    				//echo "<p>Получено объектов: $rowsCount</p>";

    				if($rowsCount != 0){
    					$user = new User();
    					if($this->get_addon_event($event_id) == 1){
							$log_table = $this->get_table_head(1);
    					}else{
    						$log_table = $this->get_table_head(0);
    					}


						foreach($result as $row2){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
		      				// echo "<tr style='background-color: #fff;'><td>".$row2['id']."</td><td>".$row2['barcode']."</td><td>".$row2['user']."</td><td>".$row2['time']."</td><td>";

							$log_table .= $this->get_table_block($row2, $user->get_login_by_id($row2['user']), $scanstatus->get_status_name($row2['status']) ,$scanstatus->get_status_color($row2['status']), $zone->is_fan(intval($row2['zone_id'])));



							if($this->get_addon_event($event_id) == 1){
								if($row2['status'] != 0){
									if($row2['inv'] == 1 ){
										$log_table .= "<td>Так</td>";
									}else{
										$log_table .= "<td>Ні</td>";
									}
								}else{
									$log_table .= "<td></td>";
								}

									if($set->sel_img == 1){
										if($sel->get_saler_img($row2['saler'])!=''){
											$log_table .= "<td><img style='border-radius:0; width: 100%; height: 100%;' src='".$sel->get_saler_img($row2['saler'])."' /></td>";

										}else{
											$log_table .= "<td></td>";
										}
									}else{
										$log_table .= "<td>".$sel->get_saler_name(intval($row2['saler']))."</td>";
									}


								$log_table .= "<td>".$row2['comment']."</td></tr>";
							}else{
								$log_table .="</tr>";
							}

						}

					   $log_table .= "</tbody></table>";
					   $result->free();
					}
				}else{
	    			echo "Ошибка: " . $this->mysqli->error;
				}
			}

			return $log_table;

		}//***Получить таблицу лога входа

		function get_addon_event($event_id){
			$addon = 0;
			$sql = "SELECT e.addon as 'addon' FROM event e WHERE e.id = {$event_id} AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row2){
					$addon = $row2["addon"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $addon;
		}

		//Получить имя активного мероприятия
  		 function get_active_event(){
  		 	$sql = "SELECT * FROM event e WHERE e.IsActive = 1 AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row2){
					$this->active_event_name = $row2["name"];
					$this->active_event_id = $row2["id"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			if ($this->active_event_name!=''){
				$active_event = ['name' => $this->active_event_name, 'id' => $this->active_event_id];
				return $active_event;
			}else{
				return "Активна подія не встановлена";
			}

  		 }//***Получить имя активного мероприятия
		//

  		 function get_active_event_id(){
  		 	$active_event_id = 0;
  		 	$sql = "SELECT * FROM event e WHERE e.IsActive = 1 AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row2){
					$active_event_id = $row2["id"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $active_event_id;

  		 }

  		 function get_active_event_name(){
  		 	$active_event_name = '';
  		 	$sql = "SELECT e.name FROM event e WHERE e.IsActive = 1 AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row2){
					$active_event_name = $row2["name"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $active_event_name;

  		 }

  		 function get_event_date($event_id){
  		 	$event_date = '';
  		 	$sql = "SELECT e.date as 'date' FROM event e WHERE e.id = {$event_id} AND e.Deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row2){
					$event_date = $row2["date"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return date('d.m.Y H:i', strtotime($event_date));

  		 }

  		 function get_max_time($event_id){
  		 	$max_time = '';
  		 	$sql = "SELECT MAX(s.time) as 'time' FROM scanlog s WHERE s.event = {$event_id} AND s.status = 1";
  		 	if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$max_time = $row["time"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $max_time;
  		 }

  		 function get_min_time($event_id){
  		 	$min_time = '';
  		 	$sql = "SELECT MIN(s.time) as 'time' FROM scanlog s WHERE s.event = {$event_id} AND s.status = 1";
  		 	if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$min_time = $row["time"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $min_time;
  		 }

		//Установить активное мероприятия
  		 function set_active_event($event_id){
			$this->mysqli->query("UPDATE event e SET e.IsActive = 0");
			$this->mysqli->query("UPDATE event e SET e.IsActive = 1 WHERE e.id = {$event_id}");
			return 'Активна подія визначена!';
		}//***Установить активное мероприятия

		//Установить статус в 0 не в зале всем штрихкодам
  		 function set_out_all_barcodes($event_id){
			return $this->mysqli->query("UPDATE eventplace e SET e.status = 0 WHERE e.event = {$event_id}");
			//return 'Активна подія визначена!';
		}

		function get_last_event_id(){
			$last_event_id = 0;

  		 	$sql = "SELECT MAX(e.id) as 'last' FROM event e WHERE e.Deleted = 0";

  		 	if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$last_event_id = $row["last"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $last_event_id;

		}


		function delete_event($event){
			$status = 0;

			if ($this->get_active_event_id() == $event){
				$status = $this->mysqli->query("DELETE FROM event e WHERE e.id = {$event}");
				$this->set_active_event($this->get_last_event_id());
			}else{
				$status = $this->mysqli->query("DELETE FROM event e WHERE e.id = {$event}");
			}

			//$status = $this->clear_barcodes($event);
			return $status;
		}

		function clear_barcodes($event){
			$status = 0;
			$status = $this->mysqli->query("DELETE FROM scanlog s WHERE s.event = {$event}");
			$status = $this->mysqli->query("DELETE FROM eventplace e WHERE e.event = {$event}");
			$status = $this->mysqli->query("DELETE FROM addon a WHERE a.event = {$event}");
			return $status;
		}

		function add_event($name, $date, $hall, $addon, $importbarcodes){
			$name = str_replace(':',"_", $name);
			$forlog = $name."_(".str_replace(':',"_", $date).")";
			$name = $name." (".date('d.m.Y H:i',strtotime($date)).")";
			//echo $name." / ".$forlog." / ".$date." / ".$hall." / ".$addon." / ".$importbarcodes."<br/>";
			$stat = $this->mysqli->query("INSERT INTO `event` (`id`, `name`, `forlog`, `date`, `IsActive`, `Deleted`, `hall`, `addon`, `import`) VALUES (NULL, '{$name}', '{$forlog}', '{$date}', '0', '0', '{$hall}', '{$addon}', '{$importbarcodes}')");
			if($stat != 1){
				return 0;
			}else{
				$this->set_active_event($this->mysqli->insert_id);
				return 1;
			}

		}

		function success_add_event_table($name, $date, $hall, $import_id){

				$success_table = '';
				$import_name = '';

                        if($import_id == 1) {$import_name = 'Заливка *.csv файлу';}
                        if($import_id == 2) {$import_name = 'Довільне завантаження штрихкодів';}

                        /*echo "<div class='row'>
                <div class='col-md-12 grid-margin' style='width:100%; flex: 0 100%;'><div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Захід створенно</div>";*/

                        $success_table .= '<div class="table-responsive">
		                    <table class="table table-striped">
		                      <thead>
		                        <tr>
		                          <th>
		                            Назва
		                          </th>
		                          <th>
		                            Дата заходу
		                          </th>
		                          <th>
		                            Зал
		                          </th>
		                          <th>
		                            Імпорт штрихкодів
		                          </th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                        <tr>
		                          <td class="py-1">
		                            '.$name.'
		                          </td>
		                          <td>
		                            '.$date.'
		                          </td>
		                          <td>
		                            '.$hall.'
		                          </td>
		                          <td>
		                            '
		                            .$import_name.'
		                          </td>
                        </tr>
                      </tbody>
                    </table></div><br><br>';
                    return $success_table;
		}

  	}//**class Event

  	class Role extends connection_bd{

  		function set_role_to_page($role, $page, $action){
			if($action == 'true'){
				return $this->mysqli->query("INSERT INTO role_to_page (`id`, `role`, `page`) VALUES (NULL, '{$role}', '{$page}')");
			}else{
				return $this->mysqli->query("DELETE FROM role_to_page rp WHERE rp.role = {$role} AND rp.page = {$page}");
			}

		}


  		function get_name_by_id($role_id){
  			$role_name = "";
			$sql = "SELECT r.name as 'name' FROM role r WHERE r.id = {$role_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$role_name = $row['name'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $role_name;
  		}

  		function get_page_by_url($url){
  			$page_id = 0;
			$sql = "SELECT p.id as 'id' FROM pages p WHERE p.url LIKE '{$url}'";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$page_id = $row['id'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $page_id;
  		}

  		function get_id_by_name($role_name){
  			$role_id = 0;
			$sql = "SELECT r.id as 'id' FROM role r WHERE r.name LIKE '{$role_name}'";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$role_id = $row['id'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $role_id;
  		}

  		//ДОСТУП РОЛИ К СТРАНИЦЕ
		function get_role_to_page($role, $page){

			$sql = "SELECT * FROM role_to_page rp WHERE rp.role = {$role} AND rp.page = {$page}";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
				if($rowsCount != 0){
					return true;
				}else{
					return false;
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		function get_rolers_table(){
			//$usr = new Event();
			//$zone = new Zone();
			//echo $this->get_user_in_group($usr->get_active_event_id(), $row['id'], $row2['group_zone']);

			$set = new Settings();

			$role_tbl = " <div class='table-responsive'><table class='table table-striped'><tr><th>ID</th><th style='text-align: center;'>Photo</th><th>Name</th><th>Access</th></tr>";


			$sql = "SELECT * FROM role r";
			$sql2 = "SELECT * FROM pages p";

			//$sql2 = "SELECT z.id as 'zid' FROM event e JOIN hall h ON e.hall=h.id JOIN zone z ON z.hall=h.id WHERE e.id = {$usr->get_active_event_id()}";
			//
			if($result = $this->mysqli->query($sql)){

   				$rowsCount = $result->num_rows; // количество полученных строк
   				if($rowsCount == 0){
   					switch($set->lang){
						case 'ukr':
							return "Нема жодного запису!!";
						break;

						case 'eng':
							return "There is no record!!";
						break;
					}
   				}else{
   					foreach($result as $row){
   						$role_tbl .= "<tr><td style='font-size:16px;'>".$row['id']."</td><td class='py-1' style='text-align: center;'>";

   						$role_tbl .= "<img src='".$row['img']."' alt='img' />";

						/*if($this->get_role_by_id($row['id']) == 'ctrl'){
							$usr_tbl .= "<img src='../img/scan_logo_ss.png' alt='image'/>";
						}else{
							if($row['img'] != ''){
								$usr_tbl .= "<img src='".$row['img']."' alt='image'/>";
   							}else{
   								$usr_tbl .= "<i class='mdi mdi-account-circle' style='font-size: 1.5rem'>";
   							}
						}*/

					    $role_tbl .="</td><td>".$row['name']."</td><td>";



					if($result2 = $this->mysqli->query($sql2)){
   						$rowsCount2 = $result2->num_rows;
   							if($rowsCount2 == 0){
   								$role_tbl .= '';
   							}else{
   								if($row['id'] != 5){
   									foreach($result2 as $row2){
   										if($row2['id'] != 9){
	   										$role_tbl .= "<input type='checkbox' role='".$row['id']."'";

											if($this->get_role_to_page($row['id'], $row2['id'])){
												$role_tbl .= " checked ";
											}

											switch($set->lang){
										     	case 'ukr':
											        $role_tbl .= " id ='".$row2['id']."' name='".$row2['name']."' /><label style='margin-left:5px;'  for='".$row2['name']."'>".$row2['name']."</label></br>";
											        break;

										      	case 'eng':
										        	$role_tbl .= " id ='".$row2['id']."' name='".$row2['name_eng']."' /><label style='margin-left:5px;'  for='".$row2['name_eng']."'>".$row2['name_eng']."</label></br>";
											        break;

									    	}


	   									}
   									}
   								}else{
   									$role_tbl .= "<p>".onlyscan."</p>";
   								}
   							}
   					}

   				   $role_tbl .= "</td></tr>";
   				}
   			}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			$role_tbl .= '</table></div>';
			return $role_tbl;
		}

	}//**class Role

	class User extends connection_bd{
		public $id = 0;
		public $name = '';
		public $login = '';
		public $password = '';
		public $role = '';
		public $last_login;
		public $img;

		function login($login, $password){
			$sql = "SELECT * FROM users u WHERE u.login LIKE '{$login}' AND u.password LIKE '{$password}'";
			//echo $sql;
			//exit;
			if($result = $this->mysqli->query($sql)){
   				$rowsCount = $result->num_rows; // количество полученных строк
   				if($rowsCount == 0){
   					return 'Невірний логін або пароль!';
   				}else{
   					foreach($result as $row){
   						$this->id = $row['id'];
   						$this->name = $row['name'];
   						$this->login = $login;
						$this->password = $password;
   						$this->role = $row['role'];
   						$this->img = $row['img'];
   						$this->mysqli->query("UPDATE users u SET u.last_login = NOW() WHERE u.id = {$row['id']}");
   					}
   					return 1;
   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		function login_mob($user){
			$sql = "SELECT * FROM users u WHERE u.id = '{$user}'";
			//echo $sql;
			//exit;
			if($result = $this->mysqli->query($sql)){
   				$rowsCount = $result->num_rows; // количество полученных строк
   				if($rowsCount == 0){
   					return 'Error: Контролер не знайден';
   				}else{
   					foreach($result as $row){
   						$this->mysqli->query("UPDATE users u SET u.last_login = NOW() WHERE u.id = {$row['id']}");
   					}
   					return 1;
   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		function set_user_to_group($event, $user, $zone, $action){
			if($action == 'true'){
				return $this->mysqli->query("INSERT INTO user_to_group (`id`, `id_user`, `id_zone`, `event`) VALUES (NULL, '{$user}', '{$zone}', '{$event}')");
			}else{
				return $this->mysqli->query("DELETE FROM user_to_group ug WHERE ug.id_user = {$user} AND ug.id_zone = {$zone} AND ug.event = {$event}");
			}

		}

		function get_user_in_group($event, $user, $zone){
			$sql = "SELECT * FROM  user_to_group ug WHERE ug.id_user = {$user} AND ug.id_zone = {$zone} AND ug.event = {$event}";
			if($user !='' && $zone !=''){
				if($result = $this->mysqli->query($sql)){
					$rowsCount = $result->num_rows;
					if($rowsCount != 0){
						return true;
					}else{
						return false;
					}
				}else{
					echo "Ошибка: " . $this->mysqli->error;
				}
			}
		}

		function get_user_path_photo($user_id){
			$path = "";
			$sql = "SELECT u.img as 'img' FROM users u WHERE u.id = {$user_id} AND u.deleted = 0";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$path = $row['img'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $path;
		}

		function get_user_photo($user_id){
			$nophoto = "<img src='../img/users/user.png' alt='image'/>";
			$sql = "SELECT u.img as 'img', u.role as 'role' FROM users u WHERE u.id = {$user_id} AND u.deleted = 0";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					if($this->get_role_by_id($user_id) == 'ctrl'){
						return "<img src='../img/users/ctrl.png' alt='image'/>";
					}else{
						if($row['img'] != ''){
							return "<img src='".$row['img']."' alt='image'/>";
	   					}else{
	   						return $nophoto;
	   					}
					}
				}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $nophoto;
		}

		function get_users_table(){
			$usr = new Event();
			$zone = new Zone();
			//echo $this->get_user_in_group($usr->get_active_event_id(), $row['id'], $row2['group_zone']);
			$usr_tbl = " <div class='table-responsive'><table class='table table-striped'><tr><th>ID</th><th style='text-align: center;'>Photo</th><th>Name</th><th>Login</th><th>Role</th><th>Last login</th><th>Mobile App</th>";

			if($usr->is_addon_event($usr->get_active_event_id()) == 1){
				$usr_tbl .="<th>Zones</th><th>Delete</th><th></th></tr>";
			}else{
				$usr_tbl .="<th>Delete</th></tr>";
			}


			$sql = "SELECT * FROM users u WHERE u.deleted = 0";
			//$sql2 = "SELECT DISTINCT(a.group_zone), g.name as 'name' FROM addon a JOIN group_name g ON a.group_zone = g.id WHERE a.event = {$usr->get_active_event_id()}";
			$sql2 = "SELECT z.id as 'zid' FROM event e JOIN hall h ON e.hall=h.id JOIN zone z ON z.hall=h.id WHERE e.id = {$usr->get_active_event_id()}";
			if($result = $this->mysqli->query($sql)){

   				$rowsCount = $result->num_rows; // количество полученных строк
   				if($rowsCount == 0){
   					return 'Невірний логін або пароль!';
   				}else{
   					foreach($result as $row){
   						$usr_tbl .= "<tr><td style='font-size:16px;'>".$row['id']."</td><td class='py-1' style='text-align: center;'>";

   						$usr_tbl .= $this->get_user_photo($row['id']);

						/*if($this->get_role_by_id($row['id']) == 'ctrl'){
							$usr_tbl .= "<img src='../img/scan_logo_ss.png' alt='image'/>";
						}else{
							if($row['img'] != ''){
								$usr_tbl .= "<img src='".$row['img']."' alt='image'/>";
   							}else{
   								$usr_tbl .= "<i class='mdi mdi-account-circle' style='font-size: 1.5rem'>";
   							}
						}*/


   						$usr_tbl .="</td><td>";
   							if($_SESSION['user_role'] == 'admin'){
   								$usr_tbl .= "<a href = '/admin/usersprofile.php?id=".$row['id']."'>".$row['name']."</a>";
   							}else{
   								$usr_tbl .= $row['name'];
   							}


   						$usr_tbl .="</td><td>".$row['login']."</td><td>".$row['role']."</td><td>".$row['last_login']."</td><td><button type='button' class='btn btn-outline-secondary btn-rounded btn-icon' data-toggle='modal' data-target='#exampleModalCenter".$row['id']."' style='margin-left:20px;'><i class='mdi mdi-cellphone-android' style='font-size: 1.3rem;'></i></button></td>";

   							if($usr->is_addon_event($usr->get_active_event_id()) == 1){
   								if($result2 = $this->mysqli->query($sql2)){
   									$rowsCount2 = $result2->num_rows;
   									if($rowsCount2 == 0){
   										$usr_tbl .= '';
   									}else{
   										$usr_tbl .= "<td>";
   										foreach($result2 as $row2){
   											$usr_tbl .= "<input type='checkbox' user='".$row['id']."'";
											if($this->get_user_in_group($usr->get_active_event_id(), $row['id'], $row2['zid']) == 1){
												$usr_tbl .= " checked ";
											}
   											$usr_tbl .= "id ='".$row2['zid']."' name='group".$row2['zid']."' /><label style='margin-left:5px;'  for='".$row2['zid']."'>".$zone->zone_name($row2['zid'])."</label></br>";
   										}
   										$usr_tbl .= "</td>";
   									}
   								}
   							}

   							$usr_tbl .= "<td><button type='button' class='btn btn-social-icon btn-outline-youtube' title='Видалити користувача' id='".$row['id']."' data-toggle='modal' data-target='#DelUserModal".$row['id']."' ><i class='mdi mdi mdi-delete' style='font-size: 1.5rem;'></i></button></td></tr>";

   					}
   					$usr_tbl .= '</table></div>';
   					return $usr_tbl;
   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		function del_user($user_id){
			$status = 0;
			$status = $this->mysqli->query("UPDATE users u SET u.deleted = 1 WHERE u.id = {$user_id}");
			return $status;
		}

		function edit_user_profile($user_id, $name, $login, $pass){
			$status = 0;
			$status = $this->mysqli->query("UPDATE users u SET u.name = '{$name}', u.login = '{$login}', u.password = '{$pass}'  WHERE u.id = {$user_id}");
			return $status;
		}

		function add_photo($user_id, $path){
			$status = 0;
			$status = $this->mysqli->query("UPDATE users u SET u.img = '{$path}' WHERE u.id = {$user_id}");
			return $status;
		}

		function get_name_by_id($user_id){
			$name = '';
			$sql = "SELECT * FROM users u WHERE u.id={$user_id}";

			if($result = $this->mysqli->query($sql)){
   					foreach($result as $row){
   						$name = $row['name'];
   					}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $name;
		}

		function get_login_by_id($user_id){
			$login = '';
			$sql = "SELECT * FROM users u WHERE u.id={$user_id}";

			if($result = $this->mysqli->query($sql)){
   					foreach($result as $row){
   						$login = $row['login'];
   					}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $login;
		}

		function get_role_by_id($user_id){
			$role = '';
			$sql = "SELECT u.role as 'role' FROM users u WHERE u.id={$user_id}";

			if($result = $this->mysqli->query($sql)){
   					foreach($result as $row){
   						$role = $row['role'];
   					}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $role;
		}

		function get_lastlogin_by_id($user_id){
			$last = '';
			$sql = "SELECT u.last_login as 'last' FROM users u WHERE u.id={$user_id}";

			if($result = $this->mysqli->query($sql)){
   					foreach($result as $row){
   						$last = $row['last'];
   					}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $last;
		}

		function add_user($name, $login, $password, $role){
			//$forlog = $name."_(".str_replace(':',"_", $date).")";
			//$name = $name." (".date('d.m.Y H:i',strtotime($date)).")";

			//echo $name." / ".$login." / ".$password." / ".$role."<br/>";

			return $this->mysqli->query("INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`, `last_login`, `img`, `deleted`) VALUES (NULL, '{$name}', '{$login}', '{$password}', '{$role}' , NOW(), '', 0)");

			//INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`, `last_login`, `img`) VALUES (NULL, 'Вася Пупкин', 'pupkin', '12345', 'visitor', '2022-11-07 11:28:50.000000', '');

		}

		function success_add_user_table($user_id, $name, $login, $role){
				$user = new User();
                $success_table .= '<div class="table-responsive">
		             <table class="table table-striped">
		                      <thead>
		                        <tr>
		                         <th>
		                          	Photo
		                          </th>
		                          <th>
		                          	Name
		                          </th>
		                          <th>
		                            Login
		                          </th>
		                          <th>
		                            Role
		                          </th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                        <tr>
		                        <td class="py-1">
		                        '.$user->get_user_photo($user_id).'
		                        	<!--<i class="mdi mdi-account-circle" style="font-size: 1.5rem"></i>-->
		                         </td>
		                         <td>
		                            '.$name.'
		                          </td>
		                          <td>
		                            '.$login.'
		                          </td>
		                          <td>
		                            '.$role.'
		                          </td>
                        </tr>
                      </tbody>
                    </table></div><br><br>';
                    return $success_table;
		}

		function get_modal_for_mob(){
			require 'barcode/vendor/autoload.php';
			$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
			$event = new Event();
			$set = new Settings();
			$activ_event = $event -> get_active_event();
			if(is_array($activ_event)){
				$activ_event_name = $activ_event['name'];
				$activ_event_id = $activ_event['id'];
			}else{
				$activ_event_name = $activ_event;
			}
			$sql = "SELECT * FROM users u WHERE u.deleted = 0";
			if($result = $this->mysqli->query($sql)){
   				$rowsCount = $result->num_rows; // количество полученных строк
   				if($rowsCount == 0){
   					return 'Невірний логін або пароль!';
   				}else{
   					foreach($result as $row){
   						$modals .= '<div class="modal fade" id="exampleModalCenter'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				      	<h3 class="modal-title" id="exampleModalCenterTitle">Login - '.$row['login'].'</h3>
				      </div>
				      <div class="modal-body">
				        <table class="table table-bordered"><tr><td><h3>';
				        switch($set->lang){
						      case 'ukr':

			   					$modals .= 'Захід';
						        break;

						      case 'eng':
								$modals .= 'Event';
						        break;

						      default:

			   					$modals .= 'Захід';
						     	 break;

						  }


				       $modals .= '</h3></td><td><h3>';

				        switch($set->lang){
						      case 'ukr':

			   					$modals .= 'Контролер';
						        break;

						      case 'eng':
								$modals .= 'Controler';
						        break;

						      default:

			   					$modals .= 'Контролер';
						     	 break;

						  }

				       $modals .= '</h3></td></tr>
				      	<tr><td><img style="border-radius: 0; width: 100%; height: 100%;" src="data:image/png;base64,'.base64_encode($generator->getBarcode($activ_event_id,'C128')).'"></td>
				      	<td><img style="border-radius: 0; width: 100%; height: 100%;" src="data:image/png;base64,'.base64_encode($generator->getBarcode($row['id'],'C128')).'"></td>
				      	</tr>
				      	</table>
				      	<br/>
				      	<h3>Url</h3>
				      	<h3>http://'.$_SERVER['SERVER_ADDR'].'/mob.php</h3>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				    </div>
				  </div>
		</div>';

   					}

   					return $modals;
   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

		}

		function get_modal_del_user(){

			$sql = "SELECT * FROM users u WHERE u.deleted = 0";
			if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){

   						$modals .= '<div class="modal fade" id="DelUserModal'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				 	<div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Видалити користувача '.$row['login'].'?</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="/admin/users.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="clear_barcode">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="clear_barcode" name="user_password" placeholder="Введіть пароль">
                              <input type="hidden" id="userId" name="userId" value="'.$row['id'].'" />
                            </div>
                            <button type="submit" class="btn btn-danger mb-2" id="del_user_btn">Видалити</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
				  </div>';

   				}

   				return $modals;
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

		}

		function get_profile_stat_table($user_id){
			$stat_table = '';
			$event_array = Array();
			$stat = new Stat();
			$event = new Event();
			$sql = "SELECT e.id as 'eid', e.name as 'eventname', count(s.id) as 'scancount' FROM scanlog s INNER JOIN eventplace p ON s.eventplace = p.id INNER JOIN event e ON p.event = e.id WHERE s.status = 1 AND s.user = {$user_id} GROUP BY eid ORDER BY e.id";

			$stat_table .= '<h3>Кількість відсканованих на вхід квитків</h3>';
			$stat_table .= '<div class="table-responsive"><table class="table" style="width: 70%;">
                            <thead><th style="font-size:20px;">ID</th><th style="font-size:20px;">Назва заходу</th><th style="font-size:20px; text-align:center;">Кілікість сканувань</th></thead><tbody>';
			if($result = $this->mysqli->query($sql)){
   				$rowsCount = $result->num_rows;

   				if($rowsCount == 0){
   					return '<h3>Користувач не відсканував жодного квитка!</h3>';
   				}

   				foreach($result as $row){

   					$event_array[] = $row["eid"];
  					$stat_table .= "<tr><td style='font-size:18px;' >".$row["eid"]."</td><td style='font-size:18px;'>".$row["eventname"]."</td><td style='font-size:18px; text-align:center;'>".$row["scancount"]."</td></tr>";
   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			$stat_table .= '</tbody></table></div></div>';

			/*echo '<pre>';
			var_dump($event_array);
			echo '</pre>';*/

			/*$stat_table .= '<br><br><h3 style="margin-right:40px;">Кількість по зонах</h3><br>';
			foreach($event_array as $active_event_id){
				$stat_table .= '<h4>'.$event->get_event_name($active_event_id).'</h4>';
				$stat_table .= '<div class="row"><div class="table-responsive" style="width: 70%;">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="font-size:20px;">Зона</th>
                                <th style="font-size:20px; text-align:center;">Всього місць у зоні</th>
                                <th style="font-size:20px; text-align:center;">Відскановано користувачем</th>
                              </tr>
                            </thead>
                            <tbody>';

                             for($i=0; $i < count($stat->get_inzone_count($active_event_id)); $i++){
                             	if($stat->get_zone_count($active_event_id, $stat->inzone[$i]['zone_id'])!=0 && $stat -> get_inzone_count_by_user($user_id, $stat->inzone[$i]['zone_id']) != 0){
	                                 $stat_table .= "<tr><td style='font-size:18px;' >".$stat->inzone[$i]['zonename']."</td>
	                                  <td style='font-size:18px; text-align:center;' class='center'><p><span class='font-weight-bold mr-4 center'>".$stat->get_zone_count($active_event_id, $stat->inzone[$i]['zone_id'])."</span></p></td>
	                                  <td style='font-size:18px; text-align:center;'><p><span class='font-weight-bold mr-4'>".$stat -> get_inzone_count_by_user($user_id, $stat->inzone[$i]['zone_id'])."</span></p></td></tr>";

	                                  //(".round(($stat->inzone[$i]['inzone']*100)/$stat->get_zone_count($active_event_id, $stat->inzone[$i]['zone_id']), 0)." %)</p></td></tr>";
	                            }
                             }

					$stat_table .= '</tbody></table></div></div><br/>';
                 }*/

			/*if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){


   				}
   				return $modals;
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}*/


			return $stat_table;
		}

		function get_count_by_id ($user_id, $event){
			$count = 0;
			$sql = "SELECT count(s.id) as 'count' FROM scanlog s WHERE s.user = {$user_id} AND s.event = {$event} AND s.status = 1";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$count = $row['count'];
   				}
			}else{
				echo "Error: " . $this->mysqli->error;
			}

			return $count;
		}

	}//***class User


	class Settings extends connection_bd{

		public $logo;
		public $show_inv;
		public $show_sel;
		public $show_lenta;
		public $exit;
		public $audio;
		public $voice;
		public $sel_img;
		public $fan_procent;
		public $lang;


		function __construct(){
			parent::__construct();
			$this->get_settings();
  		}

		public function set_settings($logo, $inv, $sel, $lenta, $exit, $audio, $voice, $fan_procent, $sel_img, $lang){
			$this->logo = $logo;
			$this->show_inv = $inv;
			$this->show_sel = $sel;
			$this->show_lenta = $lenta;
			$this->exit = $exit;
			$this->voice = $voice;
			$this->lang = $lang;
			$this->fan_procent = $fan_procent;
			$this->audio = $audio;
			$this->sel_img = $sel_img;
       		$this->mysqli->query("UPDATE settings s SET s.logo = {$this->logo}, s.show_inv = {$inv}, s.show_sel = {$sel}, s.show_lenta = {$lenta}, s.is_exit = {$exit}, s.is_audio = {$audio}, s.voice = '{$voice}', s.fan_procent = '{$fan_procent}', s.sel_img = '{$sel_img}', s.lang = '{$lang}' WHERE s.id = 1");
		}

		public static function GetLang(){

			$set = new Settings();

			return $set->lang;

		}

		public function get_settings(){
			$sql = "SELECT * FROM settings s";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->logo = $row["logo"];
					$this->show_inv = $row["show_inv"];
					$this->show_sel = $row["show_sel"];
					$this->show_lenta = $row["show_lenta"];
					$this->exit = $row["is_exit"];
					$this->audio = $row["is_audio"];
					$this->voice = $row["voice"];
					$this->fan_procent = $row["fan_procent"];
					$this->sel_img = $row["sel_img"];
					$this->lang = $row["lang"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		public function get_img_path($type){//1 - full; 2 - small

			if($type == 1){
			    if($this->logo == 2){
			    	echo '/img/scan_logo_s.jpg';
			    }

			    if($this->logo == 1){
			    	echo '/img/karabas.jpg';
			    }
			}

			if($type == 2){
			    if($this->logo == 2){
			    	echo '/img/karabas_s.png';
			    }

			    if($this->logo == 1){
			    	echo '/img/scan_logo_s.png';
			    }
			}
		}

	}//***class Settings

	class Validation extends connection_bd{

		function get_double_barcodes($event_id, $limit=0){

			$doubly = '';
			$barcodes = '';
			$set = new Settings();

			$sql = "SELECT e.barcode as 'barcode', count(e.barcode) FROM eventplace e WHERE e.event = {$event_id} GROUP BY e.barcode HAVING count(e.barcode)>1";


			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows; // количество полученных строк

	   			if($rowsCount == 0){
	   				//Дублів штрихкодів нема!
				    switch($set->lang){
				      case 'ukr':
				        $doubly .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">Дублів штрихкодів немає!</div></div></div>';
				        break;

				      case 'eng':
				       $doubly .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">There are no duplicate barcodes!</div></div></div>';
				        break;

				      default:
				      	$doubly .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">There are no duplicate barcodes!</div></div></div>';
				     	 break;

				    }

	   			}else{
	   				$count = 0;

			   		foreach($result as $row){
			   			if($count == $rowsCount-1){
			   				$barcodes .= $row['barcode'];
			   			}else{
			   				$barcodes .= $row['barcode'].",";
			   			}

			   			$count++;
			   		}

			   		 switch($set->lang){
				      case 'ukr':

	   				$doubly .= '<div class="col-md-6 stretch-card"><div class="card"><div class="card-body"><button type="button" class="btn btn-danger" style="float:left;
    margin-right: 20px;"><i class="ti-alert btn-icon-prepend"></i> Увага!</button><h4 style="margin:15px 0;" class="valid_table_head">Таблиця дублів штрихкодів - '.$rowsCount.' шт. </h4>';
					$doubly .= '<div class="table table-striped table-responsive"><table class="table"><thead><tr><th width="20%" style="font-size: 18px;">ID</th><th width="20%" style="font-size: 18px;">Зона</th><th width="20%" style="font-size: 18px;">Ряд</th><th width="20%" style="font-size: 18px;">Місце</th><th width="20%" style="font-size: 18px;">Штрихкод</th></tr>
	                      </thead><tbody>';
	                 break;

	                  case 'eng':
	                  	$doubly .= '<div class="col-md-6 stretch-card"><div class="card"><div class="card-body"><button type="button" class="btn btn-danger" style="float:left;
    margin-right: 20px;"><i class="ti-alert btn-icon-prepend"></i> WARNING!</button><h4 style="margin:15px 0;" class="valid_table_head">Table of barcode duplicates - '.$rowsCount.' piece. </h4>';
					$doubly .= '<div class="table table-striped table-responsive"><table class="table"><thead><tr><th width="20%" style="font-size: 18px;">ID</th><th width="20%" style="font-size: 18px;">Zone</th><th width="20%" style="font-size: 18px;">Row</th><th width="20%" style="font-size: 18px;">Place</th><th width="20%" style="font-size: 18px;">Barcode</th></tr>
	                      </thead><tbody>';
	                   break;
	             }


					$sql2 = "SELECT e.id as 'id', z.sector as 'zone', e.col as 'col', e.row as 'row',  e.barcode as 'barcode' FROM eventplace e JOIN zone z ON z.id = e.zone WHERE e.barcode IN ({$barcodes}) AND e.event = {$event_id} ORDER BY e.barcode";

					$count = 0;
					if($result2 = $this->mysqli->query($sql2)){
						foreach($result2 as $row2){
							$doubly .= '
		                      <tr>
		                          <td style="color:black; font-size: 16px;">'.$row2["id"].'</td>
		                          <td style="color:black; font-size: 16px;">'.$row2["zone"].'</td>
		                          <td style="color:black; font-size: 16px;">'.$row2["row"].'</td>
		                          <td style="color:black; font-size: 16px;">'.$row2["col"].'</td>
		                          <td style="color:black; font-size: 16px;">'.$row2["barcode"].'</td>
		                      </tr>';

		                      $count ++;

							  if($count == $limit*2){
								break;
							  }
						}
					}else{
						echo "Ошибка: " . $this->mysqli->error;
					}


					$doubly .= '</tbody></table></div></div></div></div>';

				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $doubly;

		}

		function get_row_same_zone_col_row($sameconcat, $event_id){

			$samerows = '';
			$samerowsarr = explode("_", $sameconcat);

			$sql = "SELECT e.id as 'id', z.sector as 'zone', e.col as 'col', e.row as 'row',  e.barcode as 'barcode' FROM eventplace e JOIN zone z ON z.id = e.zone WHERE e.zone = {$samerowsarr[0]} AND e.col = {$samerowsarr[2]} AND e.row = {$samerowsarr[1]} AND e.event = {$event_id} AND z.is_fan = 0";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$samerows .= '
		                <tr>
		                    <td style="color:black; font-size: 16px;">'.$row["id"].'</td>
		                    <td style="color:black; font-size: 16px;">'.$row["zone"].'</td>
		                    <td style="color:black; font-size: 16px;">'.$row["row"].'</td>
		                    <td style="color:black; font-size: 16px;">'.$row["col"].'</td>
		                    <td style="color:black; font-size: 16px;">'.$row["barcode"].'</td>
		               </tr>';
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $samerows;

		}

		function get_same_zone_col_row($event_id, $limit=0){

			$set = new Settings();

			$same = '';

			/*if($limit != 0){
				$limit = 'LIMIT '.$limit;
			}else{
				$limit = '';
			}*/

			$sql = "SELECT CONCAT(e.zone,'_',e.row,'_',e.col) as 'sameconcat', count(CONCAT(e.zone,'_',e.row,'_',e.col)) FROM eventplace e JOIN zone z ON z.id = e.zone WHERE e.event = {$event_id} AND z.is_fan = 0 GROUP BY CONCAT(e.zone,'_',e.row,'_',e.col) HAVING count(CONCAT(e.zone,'_',e.row,'_',e.col))>1";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows; // количество полученных строк

	   			if($rowsCount == 0){
	   				//Дублів зона, ряд, місце нема! There are no duplicates of the zone/row/place!
	   				//

	   				switch($set->lang){
				      case 'ukr':

	   					$same .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">Дублів зона/ряд/місце немає!</div></div></div>';
				        break;

				      case 'eng':

	   					$same .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">There are no duplicates of the zone/row/place!</div></div></div>';
				        break;

				      default:

	   					$same .= '<div class="col-md-6 grid-margin stretch-card"><div class="card"><div class="card-body">Дублів зона/ряд/місце немає!</div></div></div>';
				     	 break;

				    }

	   			}else{
	   				switch($set->lang){
				      case 'ukr':
				      		$same .= '<div class="col-md-6 stretch-card"><div class="card"><div class="card-body"><button type="button" class="btn btn-danger" style="float:left;margin-right: 20px;"><i class="ti-alert btn-icon-prepend"></i> Увага!</button><h4 style="margin:15px 0;" class="valid_table_head">Таблиця дублів зона, ряд, місце - '.$rowsCount.' шт.</h4>';
							$same .= '<div class="table table-striped"><table class="table-responsive"><thead><tr><th width="20%" style="font-size: 18px;">ID</th><th width="20%" style="font-size: 18px;">Зона</th><th width="20%" style="font-size: 18px;">Ряд</th>
	                          <th width="20%" style="font-size: 18px;">Місце</th><th width="20%" style="font-size: 18px;">Штрихкод</th>
	                      </tr></thead><tbody>';
				      	break;

				       case 'eng':
				       		$same .= '<div class="col-md-6 stretch-card"><div class="card"><div class="card-body"><button type="button" class="btn btn-danger" style="float:left;margin-right: 20px;"><i class="ti-alert btn-icon-prepend"></i> WARNING!</button><h4 style="margin:15px 0;" class="valid_table_head">Doubles table zone, row, place - '.$rowsCount.' piece.</h4>';
							$same .= '<div class="table table-striped"><table class="table-responsive"><thead><tr><th width="20%" style="font-size: 18px;">ID</th><th width="20%" style="font-size: 18px;">Zone</th><th width="20%" style="font-size: 18px;">Row</th>
	                          <th width="20%" style="font-size: 18px;">Place</th><th width="20%" style="font-size: 18px;">Barcode</th>
	                      </tr></thead><tbody>';
				       	break;


				  }


	                $count = 0;
	                foreach($result as $row){
						$same .= $this->get_row_same_zone_col_row($row["sameconcat"], $event_id);
						$count ++;
						if($count == $limit){
							break;
						}
	                }

					if($limit != 0){

	                	$same .= "</tbody></table></div></div></div></div><button type='button' class='btn btn-danger btn-icon-text' id='same_barcodes' style='margin:15px 10px;'>
                  <i class='mdi mdi-eye' style='vertical-align: middle;'></i> Показати усі штрихкоди</button><script>$('#same_barcodes').click(function() {
              $.ajax({
                    url: 'validation.php?event=' + $('#event').val()+'&limit=0',
                    success: function(check){
                        //alert(check);
                        $('#validation').html(check);
                    }
                });
            });";
            	}else{
            		$same .= "</tbody></table></div></div></div></div>";
            	}
	   		}

	   			return $same;
			}
		}

		function text_validation($text){
			$valid_str = '';
			$valid_str = htmlspecialchars($text, ENT_QUOTES);
			$valid_str = $this->mysqli->real_escape_string($valid_str);
			return $valid_str;
		}

	}//***class Validation

	class ToDo extends connection_bd{

		function todo_list($event_id){
			$todo = "";
			$sql = "SELECT t.id as 'id', t.text as 'text', t.chk as 'chk' FROM todo_list t WHERE t.event_id = {$event_id}";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
				if($rowsCount == 0){
					$todo = "";
				}

				foreach($result as $row){
					if($row['chk'] == 1){
						$todo .= "<li class='completed'>";
					}else{
						$todo .= "<li>";
					}

					$todo .= "<div class='form-check'><label class='form-check-label'>";

                    if($row['chk'] == 1){
                    	$todo .= "<input class='checkbox' type='checkbox' checked id='".$row['id']."'>";
                    }else{
                    	$todo .= "<input class='checkbox' type='checkbox' id='".$row['id']."'>";
                    }

                    $todo .=  $row['text'];
                    $todo .= "</label></div><!--<div class='badge badge-success badge-pill my-auto mx-2'>4</div>--><i class='remove ti-close' id='".$row['id']."'></i></li>";
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $todo;
		}

		function todo_chk($id, $status){
			return $this->mysqli->query("UPDATE todo_list t SET t.chk = {$status} WHERE t.id = {$id}");
		}

		function todo_del($id){
			return $this->mysqli->query("DELETE FROM todo_list t WHERE t.id = {$id}");
		}

		function todo_add($event, $text){
			$this->mysqli->query("INSERT INTO `todo_list` (`id`, `event_id`, `text`, `chk`) VALUES (NULL, {$event}, '{$text}', 0)");
			return $this->mysqli->insert_id;
		}


	}//***class ToDo

	class Guests extends connection_bd{

		public $id;
		public $name;
		public $organization;
		public $plus;
		public $comment;
		public $is_reg;
		public $all_access;
		public $barcode;


  		public function get_settings($guest_id){
			$sql = "SELECT * FROM guests g WHERE g.id = {$guest_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$this->id = $row["id"];
					$this->name = $row["name"];
					$this->organization = $row["organization"];
					$this->plus = $row["plus"];
					$this->comment = $row["comment"];
					$this->is_reg = $row["is_reg"];
					$this->all_access = $row["all_access"];
					$this->barcode = $row["barcode"];
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
		}

		function get_id_by_barcode($barcode){
			$event = new Event();
			$guest_id = 0;

			$sql = "SELECT g.id as 'id' FROM guests g WHERE g.barcode LIKE {$barcode} AND g.event={$event->get_active_event_id()}";

			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$guest_id = $row['id'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $guest_id;
		}

		function get_barcode_access($barcode){

			$event = new Event();

			$sql = "SELECT g.barcode as 'barcode' FROM guests g WHERE g.barcode LIKE {$barcode} AND g.event={$event->get_active_event_id()}";

			if($result = $this->mysqli->query($sql)){
				$rowsCount = $result->num_rows;
				if($rowsCount == 0){
					return false;
				}else{
					return true;
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

		}

		function get_status_name_by_id($status_id){
			$status_name = '';
			$sql = "SELECT g.name as 'name' FROM guestlog_status g WHERE g.status = {$status_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$status_name = $row['name'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $status_name;
		}

		function get_guestlog_status_select(){
			$stat_html = '';
			$sql = "SELECT * FROM `guestlog_status`";

			$set = new Settings();

			switch($set->lang){
				case 'ukr':
					$stat_html .= "<span style='font-weight:bold; float:left; padding:0 5px;'>Статус</span><select name='guest_status' id='guest_status'>";
					$stat_html .= "<option value='-1'>Усі</option>";
				break;

				case 'eng':
					$stat_html .= "<span style='font-weight:bold; float:left; padding:0 5px;'>Status</span><select name='guest_status' id='guest_status'>";
					$stat_html .= "<option value='-1'>All</option>";
				break;

				default:
					$stat_html .= "<span style='font-weight:bold; float:left; padding:0 5px;'>Статус</span><select name='guest_status' id='guest_status'>";
					$stat_html .= "<option value='-1'>Усі</option>";
				break;
			}


			if($result = $this->mysqli->query($sql)){
				 foreach($result as $row){
				 	switch($set->lang){
					 	case 'ukr':
							$stat_html .= "<option style='' value='".$row['status']."'>".$row['name']."</option>";
						break;

						case 'eng':
							$stat_html .= "<option style='' value='".$row['status']."'>".$row['name_eng']."</option>";
						break;
					}
				}


				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			$stat_html .= "</select>";
			return $stat_html;
		}

		function get_status_color_by_id($status_id){
			$status_color = '';
			$sql = "SELECT g.color as 'color' FROM guestlog_status g WHERE g.status = {$status_id}";
			if($result = $this->mysqli->query($sql)){
				foreach($result as $row){
					$status_color = $row['color'];
				}
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $status_color;
		}

		function get_guestlog_table($status = -1){

			$event = new Event();
			$user = new User();
			$set = new Settings();

			$where = '';

			if($status != -1){
				$where = ' AND gl.status = '.$status;
			}

			$guestlog_table = '';
			$guestlog_table .='<div class="col-lg-12 stretch-card"><div class="card"><div class="card-body"><div class="table-responsive pt-3">';

			switch($set->lang){
				case 'ukr':
					$guestlog_table .= "<table class='table table-bordered'><thead><tr><th>ID</th><th>П.І.О</th><th>Організація</th><th>Штрихкод</th><th>Кількість плюсів</th><th>Час</th><th>Статус</th><th>Контролер</th></tr></thead><tbody>";
				break;

				case 'eng':
					$guestlog_table .= "<table class='table table-bordered'><thead><tr><th>ID</th><th>Full name</th><th>Organization</th><th>Barcode</th><th>Number of pluses</th><th>Time</th><th>Status</th><th>Controler</th></tr></thead><tbody>";
				break;
			}


			$sql = "SELECT gl.id as 'id', g.name as 'name', g.organization as 'org', gl.plus as 'plus', gl.barcode as 'barcode', gl.time as 'time', gl.status as 'status', gl.user as 'user' FROM guestlog gl LEFT JOIN guests g ON g.id = gl.guest_id WHERE gl.event = {$event->get_active_event_id()} {$where}";

			if($result = $this->mysqli->query($sql)){

				$rowsCount = $result->num_rows;
				if($rowsCount == 0){
					switch($set->lang){
						case 'ukr':
							return "Нема жодного запису!!";
						break;

						case 'eng':
							return "There is no record!!";
						break;
					}

				}

				foreach($result as $row){
					$guestlog_table .= "<tr class='".$this->get_status_color_by_id($row['status'])."'>";
					$guestlog_table .= "<td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['org']."</td><td>";

					if($row['barcode'] != ''){
						$guestlog_table .= $row['barcode'];
					}else{
						$guestlog_table .= "Гість не зареєстрован";
					}

					$guestlog_table .= "</td><td>".$row['plus']."</td><td>".$row['time']."</td><td>".$this->get_status_name_by_id($row['status'])."</td><td>".$user->get_login_by_id($row['user'])."</td>";

				}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			$guestlog_table .= '</table></div></div></div></div>';

			return $guestlog_table;
		}


		function delete_guest_list(){
			$event = new Event();
		    return $this->mysqli->query("DELETE FROM guests g WHERE g.event = {$event -> get_active_event_id()}");
		}

		function insert_log_row($guest_id, $status, $plus, $barcode, $user){ //По плюсах - 1, Реєстрація - 2, Друк - 3, Вхід у зону
			$event = new Event();
			return $this->mysqli->query("INSERT INTO guestlog (`id`,`event`, `guest_id`,  `barcode`, `time`, `plus`, `status`, `user`) VALUES (NULL, {$event->get_active_event_id()},{$guest_id},'{$barcode}', NOW(), {$plus}, {$status}, {$user})");
		}


		function get_guests_table($name = '', $status = -1){

			$event = new Event();

			if( $name == '' ){
				$where = 'g.event = '.$event->get_active_event_id();
			}else{
				$where = 'g.event = '.$event->get_active_event_id().' AND g.name LIKE "%'.$name.'%"';
			}

			switch ($status){
				case 0:
			    	$where .= ' AND g.is_reg = 0';
			        break;

			    case 1:
			    	$where .= ' AND g.is_reg = 1';
			        break;

			    case 2:
			    	$where .= ' AND g.inhall > 0';
			        break;

			}

			$sql = "SELECT * FROM guests g WHERE {$where}";

			$guest_tbl = "";

			$guest_tbl = '<div class="col-lg-12 grid-margin stretch-card print"><div class="card"><div class="card-body">
				<div class="table-responsive">
                    <table class="table table-striped">
                      <thead><tr><th>Фото</th><th>П.І.О</th><th>Реєстрація</th><th>Кількість плюсів</th><th>Вхід</th><th>Плюси зайшли</th><th>Прогрес входу плюсів</th><th>Зони доступу</th></tr></thead><tbody>';

            $guest_tbl .= "<tbody>";
            $print = 'print_guest.php';

            if($result = $this->mysqli->query($sql)){

            	$rowsCount = $result->num_rows;
				if($rowsCount == 0){
					return "Нема жодного запису!!";
				}

				foreach($result as $row){
					$guest_tbl .= "<tr>
            				<td class='py-1'>
                            	<img src='../img/users/user.png' alt='image'/>
                          	</td><td>
                            <a hraf='#' data-toggle='modal' data-target='#AddInfoGuest".$row['id']."' style='cursor: pointer; text-decoration:underline;'>".$row["name"]."</a>
                          </td><td>";

			if($row["is_reg"] == 0){
				$guest_tbl .= "<button type='button' class='btn btn-danger btn-icon-text' guestid='".$row['id']."'>
                          <i class='mdi mdi-checkbox-marked-outline btn-icon-prepend'></i>
                          Реєстрація
                        </button>";
			}else{
				$guest_tbl .= "<button type='button' class='btn btn-info btn-icon-text' guest_print=".$row['id'].">
                          Друк
                          <i class='ti-printer btn-icon-append'></i>
                        </button>";
			}



			$guest_tbl .= "</td><td>
                            <div class='btn-group' role='group' aria-label='Basic example'>
                              <button type='button' class='btn btn-outline-secondary'>-</button>
                              <button type='button' class='btn btn-outline-secondary'>".$row["plus"]."</button>
                              <button type='button' class='btn btn-outline-secondary'>+</button>
                            </div>
                          </td><td>
                             <button type='button' guest='".$row["plus"]."' data-toggle='modal' data-target='#PlusGoModal".$row['id']."' class='btn btn-social-icon btn-outline-youtube' ";

							if($row["plus"] <= 0)
								$guest_tbl .= 'disabled';

                            $guest_tbl .= "><i class='mdi mdi-run icon-md'></i></button>
                          </td><td>
                             <div class='btn-group' role='group' aria-label='Basic example'>
                               <button type='button' class='btn btn-primary'>
                               <i class='mdi mdi-account-plus'></i>
                            </button>
                            <button type='button' class='btn btn-primary'>".$row["inhall"]."</button>
                            </div>
                          </td><td>
                          		<div class='progress'>";


                    $count = $row["plus"]+$row["inhall"];
                    if($count !=0){
	                    if($row["inhall"]*100/$count == 100){
	                    	$guest_tbl .= "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$row["inhall"]*100/$count."%' aria-valuenow='5' aria-valuemin='1' aria-valuemax='5'></div></div>";
	                    }else{
	                    	$guest_tbl .= "<div class='progress-bar bg-info' role='progressbar' style='width: ".$row["inhall"]*100/$count."%' aria-valuenow='5' aria-valuemin='1' aria-valuemax='5'></div></div>";
	                    }
                    }else{
                    	$guest_tbl .= "<div class='progress-bar bg-info' role='progressbar' style='width: 0%' aria-valuenow='5' aria-valuemin='1' aria-valuemax='5'></div></div>";
                    }


                 $guest_tbl .=  "</td><td>
                          		All access
                          </td></tr>";
				}
				$result->free();
			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

            $guest_tbl .=  "</tbody></table>";

            $guest_tbl .= '</div></div></div></div>';

            return $guest_tbl;
		}

		function plus_go($count, $plus, $id){

			if($count > $plus){
				return "Хоче зайти більша кількість ніж плюсів!!";

			}

			return $this->mysqli->query("UPDATE guests g SET g.inhall = g.inhall + {$count}, g.plus = g.plus - {$count} WHERE g.id = {$id}");
		}

		function reg_guest($guest_id){
			$barcode = rand(320110000000, 320150000000);
			return $this->mysqli->query("UPDATE guests g SET g.is_reg = 1, g.barcode = '{$barcode}' WHERE g.id = {$guest_id}");
		}

		function get_modal_plus_go(){

			$event = new Event();

			$sql = "SELECT * FROM guests g WHERE g.event = {$event->get_active_event_id()}";


			if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){

   						$modals .= '<div class="modal fade" id="PlusGoModal'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				 	<div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Зайшли по плюсах</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="/admin/guests.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="clear_barcode">Введіть пароль</label>-->
                              <input type="text" style="width:80px;" class="form-control" id="plus_go'.$row['id'].'" name="plus_go" value = "'.$row['plus'].'">
                              <input type="hidden" id="guestId'.$row['id'].'" name="guestId" value="'.$row['id'].'" />
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="go_plus_btn'.$row['id'].'">Зайшли</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
				  </div>
				  <script>
				  	$( document ).ready(function(){
				  		$("#go_plus_btn'.$row['id'].'").click(function(){
				  			 $.ajax({
                              url: "plus_go.php?plus="+$("#plus_go'.$row['id'].'").val()+"&id="+$("#guestId'.$row['id'].'").val(),
                                  success: function(data){
                                      alert(data);
                                      window.location.reload();
                                  }
                              });
				  });
				});</script>';

   				}

   				return $modals;
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

		}

		function get_modal_for_guest(){

			$event = new Event();
			$user = new User();
			$modals = "";
			require 'barcode/vendor/autoload.php';
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

			$sql = "SELECT * FROM guests g WHERE g.event = {$event->get_active_event_id()}";
			if($result = $this->mysqli->query($sql)){

   					foreach($result as $row){
   						$modals .= '<div class="modal fade" id="AddInfoGuest'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Додаткова інформація гостя</h3>
                        </div>
                        <div class="modal-body" style="padding: 5px 26px;">
                           <div class="row">
                  <div class="col-lg-12 grid-margin stretch-card" style="padding:0;">
                    <div class="card">
                       <div class="card-body">
                        <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                         <div class="prof_foto">'.$user->get_user_photo(200).'
                        </div>
                       </div>
                       <div class="col-md-6 mb-4 stretch-card transparent">
                        <form class="forms-sample" action="/admin/guests.php?id='.$row['id'].'" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <br>
                            <label style="font-weight:600;">Фото гостя</label><br>
                            <input type="file" name="img[]" class="file-upload-default">
                            <div class="input-group col-xs-12">
                              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                              <span class="input-group-append">
                                <button class="file-upload-browse btn btn-warning" type="button">Upload</button>
                              </span>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary mr-2">Завантажити фото</button>
                          </form>
                       </div>
                        </div><div class="row">
                       <div class="col-md-12 mb-4 stretch-card transparent">
                         <div class="table-responsive" style="overflow-x: unset;">
                          <br>
                           <table class="table table-striped">
                             <tbody>
                              <tr><td><span style="font-weight:600;">ПІО:</span></td><td>'.$row['name'].'</td></tr>
                                <tr><td><span style="font-weight:600;">Організація:</span></td><td>'.$row['organization'].'</td></tr>
                                <tr><td><span style="font-weight:600;">Коментар:</span></td><td>'.$row['comment'].'</td></tr>
                                <tr><td><span style="font-weight:600;">Статус:</span> </td>
                                  <td>';

                                  if($row['barcode'] != ''){
                                  		$modals .= ' <img style="border-radius: 0; width: 100%; height: 100%;" src="data:image/png;base64,'.base64_encode($generator->getBarcode($row['barcode'],'C128')).'"/><br/>'.$row['barcode'];

                                  }else{
                                  		$modals .= 'Гість не зареєстрован';
                                  }


                                 $modals .= '</td>
                                </tr>
                            <tbody>
                          </table>
                        </div>
                      </div>
                      </div>
                      </div>
                    </div>
                  </div>
         				 </div>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>';


   				}
   			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}

			return $modals;

		}

		function get_csv_str_table_guests(){

			$csv_tbl = '';

			$csv_tbl .= '<h3>Структура csv файлу</h3>';

			$csv_tbl .= '<table class="table table-dark"><tr><th>П.І.О</th><th>Організація</th><th>Кількість плюсів</th><th>Коментар</th><th>All access (0/1)</th></tr>
				<tr><td>"Петров Станіслав"</td><td>"ЗСУ"</td><td>12</td><td>"Прийдуть двома группами"</td><td>0</td></tr>
				</table>';

			return $csv_tbl;
		}

		function add_guest($name, $org, $plus, $comment, $all_acess){
			$event = new Event();
			return $this->mysqli->query("INSERT INTO `guests` (`id`, `name`, `organization`, `event`, `plus`, `inhall`, `comment`, `is_reg`, `all_access`,`barcode`, `foto`) VALUES (NULL, '{$name}', '{$org}', {$event->get_active_event_id()}, $plus, 0, '{$comment}', 0, {$all_acess}, '', '')");
		}

		function get_total_guest($event_id){

			$total_guest = 0;

			$sql = "SELECT COUNT(g.id) as 'count' FROM guests g WHERE g.event = {$event_id}";

			if($result = $this->mysqli->query($sql)){
   					foreach($result as $row){
   						$total_guest = $row['count'];
   					}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $total_guest;
		}

		function get_total_reg($event_id){

			$total_reg = 0;

			$sql = "SELECT COUNT(g.id) as 'count' FROM guests g WHERE g.event = {$event_id} AND g.is_reg = 1";

			if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){
   					$total_reg = $row['count'];
   				}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $total_reg;
		}

		function get_total_plus($event_id){
			$total_plus = 0;

			$sql = "SELECT SUM(g.plus) as 'count', SUM(g.inhall) as 'count2' FROM guests g WHERE g.event = {$event_id}";

			if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){
   					if($row['count'] > 0 || $row['count2'] > 0)
   						$total_plus = $row['count'] + $row['count2'];
   					else
   						$total_plus = 0;
   				}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $total_plus;

		}

		function get_inhall_plus($event_id){

			$inhall_plus = 0;

			$sql = "SELECT SUM(g.inhall) as 'count' FROM guests g WHERE g.event = {$event_id}";

			if($result = $this->mysqli->query($sql)){
   				foreach($result as $row){
   					if($row['count'] > 0)
   						$inhall_plus = $row['count'];
   					else
   						$inhall_plus = 0;
   				}

			}else{
				echo "Ошибка: " . $this->mysqli->error;
			}
			return $inhall_plus;
		}

		//Импорт в базу шк
		function import_guest_from_csv(){
			$count = 0;
			if(!empty($_FILES['passed_file']['tmp_name'])){
				$f=fopen($_FILES['passed_file']['tmp_name'], 'rb');
				if(!$f) die('error opening file');
				while($row=fgetcsv($f, 128,';')){

					if($this->add_guest($row[0], $row[1], $row[2], $row[3], $row[4]) == 1){
						$count++;
					}
				}
				fclose($f);
			}
			return "Додано гостей у базу - ".$count;
		}//***Импорт в базу шк

	}//***class Guests

	//$event = new Event();
	//echo $event -> Get_active_event_name();
	
?>