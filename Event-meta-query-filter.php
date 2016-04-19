				// Query for events that are either before or after today's date,
				// depending on what the query string variable 'display_calendar' says.
				$archive_args['meta_query'] = array(
					array(
						'key' => 'end_date',
						'value' => $todays_date_formatted,
					)
				);


				// $_GET['displaycalendar'] might equal "current" or "past"
				if( isset($_GET['displaycalendar'])){
					$which_calendar_to_display_here = $_GET['displaycalendar'];
				} else{ 
					$which_calendar_to_display_here = 'current';
				} 
			// $which_calendar_to_display_here = 
			// }
				if ( $which_calendar_to_display_here === 'past' ) {
					$archive_args['meta_query'][0]['compare'] = '<=';
				} else {
					$archive_args['meta_query'][0]['compare'] = '>=';
				}


							<div class="dropdown">
			<a class="event-date" > Upcoming and Past Events </a>
				<div class="submenu-time">
					<ul class="root">
					<li>
						<a href="?displaycalendar=current">Current Events</a>
					</li>
					<li >
						<a href="?displaycalendar=past" >Past Events</a>
					</li>
					</ul>
				</div>
			</div>
		</div>


		