<div align="center"> Create Parade
	<table border="0" align="center">
		<tr>
			<?php


			if ($this->session->flashdata()) {
				echo '<div style="width: 100%; background-color: #F42E17; color: #F4f6f6; border: solid 1px; text-align: center;">' . $this->session->flashdata('error') . '</div>';
			}

			echo form_open_multipart('parade/createParade');
			echo '<td>' . form_label('Parade name', 'Parade name') . '</td>';
			echo '<td>' . form_input('name', '', 'required') . '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('Parade area', 'Parade area') . '</td>';
			echo '<td>' . form_input('area', '', 'required') . '</td>';
			echo '</tr>';

			echo '<tr>';

			echo '<td>' . form_label('Date', 'Date') . '</td>';
			echo '<td>';
			echo '<span> M ' . form_dropdown('month', $months, '') . '</span>';
			echo '<span> D' . form_dropdown('date', $dates, '') . '</span>';
			echo '<span> Y ' . form_dropdown('year', $years, '') . '</span>';
			echo '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('Start time', 'Start time') . '</td>';
			echo '<td>';
			echo '<span> H ' . form_dropdown('hour', $hour, '') . '</span>';
			echo '<span> M ' . form_dropdown('minute', $minute, '') . '</span>';
			echo '<span> S . ' . form_dropdown('second', $second, '') . '</span>';
			echo '<span> am ' . form_radio('am_pm', 'am', 'true') . '</span>';
			echo '<span> pm ' . form_radio('am_pm', 'pm', '') . '</span>';

			echo '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('Route id', 'Route id') . '</td>';
			$route_data = array(
				'name' => 'route_id',
				'value' => $next_route_id,
				'required' => true,
				'readonly' => 'readonly'
			);
			//echo '<td>'.form_input('route_id', $next_route_id, 'required').'</td>';
			echo '<td>' . form_input($route_data) . '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('No. of floats', 'No. of floats') . '</td>';
			echo '<td>' . form_input('floats', '', 'required') . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>' . form_label('Banner ad', 'Banner ad') . '</td>';
			echo '<td>' . form_input('banner', '', ) . '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('Start latitude', 'latitude') . '</td>';
			echo '<td>' . form_input('lat', '', 'required') . '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . form_label('Start longitude', 'longitude') . '</td>';
			echo '<td>' . form_input('lon', '', 'required') . '</td>';
			echo '</tr>';


			echo '<tr>';
			echo '<td>' . form_label('Sponsor ad', 'Sponsor ad') . '</td>';
			echo '<td>' . form_input('sponsor_ad', '', ) . '</td>';
			echo '</tr>';


			echo '<tr>';
			echo '<td>' . form_label('Image', 'Image') . '</td>';
			echo '<td><input type="file" name="userfile" size="20" /></td>';
			echo '</tr>';

			echo '<tr>';
			$data = array(
				'name' => 'submit',
				'value' => 'Submit',
				'class' => 'ui-widget',
			);
			//echo '<td></td><td>'.form_submit($data).'</td>';
			echo '<td></td><td><button id="create-parade">Create parade</button></td>';
			echo '</tr>';
			//echo anchor('users/register', 'Create Account');
			echo form_close();
			?>
	</table>

</div>