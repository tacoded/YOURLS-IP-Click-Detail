<?php
/*
Plugin Name: IP Click Detail
Plugin URI: https://github.com/tacoded/YOURLS-IP-Click-Detail
Description: Shows click level IP address detail and User Agent, Referrer
Version: 1.1
Author: tacoded
Author URI: https://github.com/tacoded
*/

yourls_add_action( 'post_yourls_info_stats', 'ip_do_page' );

function ip_do_page($shorturl) {
        $nonce = yourls_create_nonce('ip');
        global $ydb;
        $base  = YOURLS_SITE;
        $table_url = YOURLS_DB_TABLE_URL;
        $table_log = YOURLS_DB_TABLE_LOG;
        $outdata         = '';

        $query = $ydb->fetchObjects("SELECT * FROM `$table_log` WHERE shorturl='$shorturl[0]' ORDER BY click_id DESC");

        if ($query) {
                foreach( $query as $query_result ) {				
			$me = "";$me2 = "";
			if ($query_result->ip_address == $_SERVER['REMOTE_ADDR']) { $me = " bgcolor='#d4eeff'"; $me2 = "<br><i>this is your ip</i>";}
                        
			$outdata .= '<tr'.$me.'><td>'.$query_result->click_time.'</td>
						<td>'.$query_result->click_id.'</td><td>'.$query_result->country_code.'</td>
						<td><a href="https://who.is/whois-ip/ip-address/'.$query_result->ip_address.'" target="blank">'.$query_result->ip_address.'</a>'.$me2.'</td>
						<td style="word-break: break-all;">'.$query_result->user_agent.' ['.$query_result->referrer.']</td></tr>'; }

			echo '<table width="850" border="1" cellpadding="5" style="margin-top:25px;"><tr><td width="80">Timestamp</td><td>ID</td><td>Country</td>
				<td>IP Address</td><td>User Agent [Referrer]</td></tr>' . $outdata . "</table><br>\n\r"; }
	}
	
	
