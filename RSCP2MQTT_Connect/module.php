<?php

declare(strict_types=1);
require_once __DIR__ . '/../libs/RSCPModule.php';


	class RSCP2MQTT_Connect extends RSCPModule
	{	
		//Topic als Konstante definieren
		const TOPIC = 'e3dc';

		////////// Commands for E3DC RSCP2MQTT /////////////

		public function force_update()
		{
			$Topic = 'e3dc/set/force';
			$Payload = 'true';
			$this->sendMQTT($Topic, $Payload);
		}
		public function set_refresh_interval(int $value)
		{
			if ($value >=1 and $value <=10){
			$Topic = 'e3dc/set/interval';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);
			}
		}
		public function activate_pvi_requests(bool $value)
		{	
			$Topic = 'e3dc/set/requests/pvi';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function activate_pm_request(bool $value)
		{
			$Topic = 'e3dc/set/requests/pm';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_mode_auto()
		{
			$Topic = 'e3dc/set/power_mode';
			$Payload = 'auto';
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_mode_idle(int $cycles)
		{
			$Topic = 'e3dc/set/power_mode';
			$Payload = 'idle:'.strval($cycles);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_mode_discharge(int $value, int $cycles)
		{
			$Topic = 'e3dc/set/power_mode';
			$Payload = 'discharge:'.strval($value).':'.strval($cycles);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_mode_charge(int $value, int $cycles)
		{
			$Topic = 'e3dc/set/power_mode';
			$Payload = 'charge:'.strval($value).':'.strval($cycles);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_mode_gridcharge(int $value, int $cycles)
		{
			$Topic = 'e3dc/set/power_mode';
			$Payload = 'grid_charge:'.strval($value).':'.strval($cycles);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_manual_charge(int $value)
		{
			$Topic = 'e3dc/set/manual_charge';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_weather_regulation(bool $value)
		{	
			$Topic = 'e3dc/set/weather_regulation';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_power_limits_mode(bool $value)
		{	
			$Topic = 'e3dc/set/power_limits';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_max_discharge_power(int $value)
		{
			$Topic = 'e3dc/set/max_discharge_power';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_max_charge_power(int $value)
		{
			$Topic = 'e3dc/set/max_charge_power';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);
		}

		public function set_wb_battery_to_car_mode(bool $value)
		{
			$Topic = 'e3dc/set/wallbox/discharge_battery_to_car';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_battery_before_car_mode(bool $value)
		{
			$wb_battery_to_car_mode = $this->GetValue('wb_battery_to_car_mode');
			if (($value) and ($wb_battery_to_car_mode))
			{
					$this->set_wb_battery_to_car_mode(false);
					IPS_SetDisabled($this->GetIDForIdent('wb_battery_to_car_mode'), true);
			}
			else
			{
					IPS_SetDisabled($this->GetIDForIdent('wb_battery_to_car_mode'), false);
			}
			$Topic = 'e3dc/set/wallbox/charge_battery_before_car';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';		
			$this->sendMQTT($Topic, $Payload);	
		}
		
		public function set_wb_max_current(int $value)
		{
			$Topic = 'e3dc/set/wallbox/max_current';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_sun_mode(bool $value)
		{
			$Topic = 'e3dc/set/wallbox/sun_mode';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_charging(bool $value)
		{
			$Topic = 'e3dc/set/wallbox/toggle';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_battery_discharge_until(int $value)
		{            
			$Topic = 'e3dc/set/wallbox/discharge_battery_until';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_disable_battery_at_mix_mode(bool $value)
		{
			$Topic = 'e3dc/set/wallbox/disable_battery_at_mix_mode';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_number_of_phases(int $value)
		{            
			$Topic = 'e3dc/set/wallbox/number_phases';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_index(int $value)
		{            
			$Topic = 'e3dc/set/wallbox/index';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_limit_charge(int $value)
		{            
			$Topic = 'e3dc/set/limit/charge/soc';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_limit_discharge(int $value)
		{            
			$Topic = 'e3dc/set/limit/discharge/soc';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_limit_discharge_durable(bool $value)
		{            
			$Topic = 'e3dc/set/limit/discharge/durable';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_limit_charge_durable(bool $value)
		{            
			$Topic = 'e3dc/set/limit/charge/durable';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_limit_discharge_by_home_power(int $value)
		{            
			$Topic = 'e3dc/set/limit/discharge/by_home_power';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}
		
		// backported from https://github.com/Treasy79/IPS-E3DC-RSCP/blob/dev-newTreelogic/
		public function GetConfigurationForm()
		{
			// Read FORM.JSON from directory to adjust Tree Values
			$jsonform = json_decode(file_get_contents(__DIR__."/form.json"), true);

			// Read actual Tree Property with the stored Data to transfer the Keep Status 
			$StoredRows = json_decode($this->ReadPropertyString('Variables'), true);

			$Variables_Form = [];
			// Process the Static ARRAY with the Variable Definitions
        	foreach (static::$Variables as $Pos => $Variable) {
				// Get Keep Status of stored Dataset from selected Datasets by User
				$keep = $Variable[10];
				if ($this->ReadPropertyString('Variables') != '' ){
					foreach ($StoredRows as $Index => $Row) {
						if ($Variable[3] == str_replace(' ', '', $Row['Ident'])) {
							$keep = $Row['Keep'];
						}
					}
				}
				$Variables_Form[] = [
					'id'          	=> $Variable[1],
					'parent'		=> $Variable[2],
					'Namespace'	  	=> $this->Translate($Variable[0]),
					'Ident'        	=> str_replace(' ', '', $Variable[3]),
					'Name'         	=> $this->Translate($Variable[3]),
					'Tag'		   	=> $Variable[4],
					'MQTT'		   	=> $Variable[5],
					'VarType'      	=> $Variable[6],
					'Profile'      	=> $Variable[7],
					'Factor'       	=> $Variable[8],
					'Action'       	=> $Variable[9],
					'Keep'         	=> $keep,
					'rowColor'     	=> $this->set_color($Variable[2]),
					'editable'     	=> $this->set_editable($Variable[2])
				];
        	}
			// Update Tree Values in the respective Form Array	
			$jsonform["elements"][0]["values"] = $Variables_Form;
			$this->SendDebug('RSCP Form_post', json_encode($jsonform),0);
			return json_encode($jsonform);
		}

		public function RequestAction($Ident, $Value)
		{
			switch ($Ident){
				case "ems_power_limits_used":
					$this->set_power_limits_mode($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
					break;

				case "ems_wetaher_charge_active":
					$this->set_weather_regulation($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
					break;
				
				case "ems_max_discharge_power":
					$this->set_max_discharge_power($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
					break;
					
				case "ems_max_charge_power":
					$this->set_max_charge_power($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
					break;
				
				case "wb_battery_to_car_mode":
					$this->set_wb_battery_to_car_mode($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;
				
				case "wb_battery_before_car_mode":
					$this->set_wb_battery_before_car_mode($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;
						
				case "wb_max_current":
					$this->set_wb_max_current($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;

				case "wb_sun_mode":
					$this->set_wb_sun_mode($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;

				case "wb_charging":
					$this->set_wb_charging($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;

				case "wb_battery_discharge_until":
					$this->set_wb_battery_discharge_until($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;

				case "wb_disable_battery_at_mix_mode":
					$this->set_wb_disable_battery_at_mix_mode($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	

				case "wb_number_phases":
					$this->set_wb_number_of_phases($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	

				case "wb_index":
					$this->set_wb_index($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	

				case "lim_limit_charge":
					$this->set_limit_charge($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	
				case "lim_limit_discharge":
					$this->set_limit_discharge($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	
				case "lim_limit_charge_durable":
					$this->set_limit_charge_durable($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	
				case "lim_limit_discharge_durable":
					$this->set_limit_discharge_durable($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;	
				case "lim_limit_discharge_by_home_power":
					$this->set_limit_discharge_by_home_power($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;
				case "resetVariables":
					$this->resetVariables();
				break;	
				case "update_Variable_position":
					$this->update_Variable_position();
				break;
				case "update_Variable_name":
					$this->update_Variable_name();
				break;
				default:
					throw new Exception("Invalid Ident");

			}
		}
			
		// Mapping Definition für die MQTT Werte - RSCP2MQTT
		public static $Variables = [
		// 	NSPACE  	POS	 PARENT		IDENT									RSCP TAG 											MQTT Topic									Variablen Typ			Var Profil	  			Faktor  ACTION  KEEP
			// EMS
			['HEADER'	,100	, 0		,'EMS'									, ''												, ''										, ''				, 	''						,  1	, false, false],
			['EMS'		,101	,100	,'solar_power'							, 'TAG_EMS_POWER_PV'								, 'e3dc/solar/power'						, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1	, false, true],
			['EMS'		,102	,100	,'battery_power'						, 'TAG_EMS_POWER_BAT' 								, 'e3dc/battery/power'						, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1	, false, true],
			['EMS'		,103	,100	,'home_power'							, 'TAG_EMS_POWER_HOME'								, 'e3dc/home/power'							, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1	, false, true],
			['EMS'		,104	,100	,'grid_power'							, 'TAG_EMS_POWER_GRID'								, 'e3dc/grid/power'							, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1	, false, true],
			['EMS'		,105	,100	,'addon_power'							, 'TAG_EMS_POWER_ADD'								, 'e3dc/addon/power'						, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			, -1	, false, true],
			['EMS'		,110	,100	,'ems_max_discharge_power'				, 'TAG_EMS_MAX_DISCHARGE_POWER'						, 'e3dc/ems/max_discharge/power'			, VARIABLETYPE_INTEGER, 'RSCP.Power.W.i'		,  1	, true , true],
			['EMS'		,111	,100	,'ems_max_charge_power'					, 'TAG_EMS_MAX_CHARGE_POWER'						, 'e3dc/ems/max_charge/power'				, VARIABLETYPE_INTEGER, 'RSCP.Power.W.i'		,  1	, true , true],
			['EMS'		,112	,100	,'ems_power_limits_used'				, 'TAG_EMS_POWER_LIMITS_USED'						, 'e3dc/ems/power_limits'					, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, true , true],
			['EMS'		,113	,100	,'ems_wetaher_charge_active'			, 'TAG_EMS_WEATHER_REGULATED_CHARGE_ENABLED'		, 'e3dc/ems/weather_regulation'				, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, true , true],
			['EMS'		,120	,100	,'ems_charging_lock'					, 'TAG_EMS_STATUS'									, 'e3dc/ems/charging_lock'					, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,121	,100	,'ems_discharging_lock'					, 'TAG_EMS_STATUS'									, 'e3dc/ems/discharging_lock'				, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,122	,100	,'ems_emergency_power_available'		, 'TAG_EMS_STATUS'									, 'e3dc/ems/emergency_power_available'		, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,123	,100	,'ems_charging_throttled'				, 'TAG_EMS_STATUS'									, 'e3dc/ems/charging_throttled'				, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,124	,100	,'grid_in_limit'						, 'TAG_EMS_STATUS'									, 'e3dc/grid_in_limit'						, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,125	,100	,'ems_charging_time_lock'				, 'TAG_EMS_STATUS'									, 'e3dc/ems/charging_time_lock'				, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,126	,100	,'ems_discharging_time_lockr'			, 'TAG_EMS_STATUS'									, 'e3dc/ems/discharging_time_lock'			, VARIABLETYPE_BOOLEAN, '~Switch'	 			,  1	, false, true],
			['EMS'		,130	,100	,'autarky'								, 'TAG_EMS_AUTARKY'									, 'e3dc/autarky'							, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['EMS'		,131	,100	,'consumed'								, 'TAG_EMS_CONSUMED'								, 'e3dc/consumed'							, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['EMS'		,140	,100	,'ems_set_power_power'					, 'TAG_EMS_SET_POWER'								, 'e3dc/ems/set_power/power'				, VARIABLETYPE_INTEGER, 'RSCP.Power.W.i'		,  1	, false, true],
			['EMS'		,150	,100	,'ems_mode'								, 'TAG_EMS_MODE'									, 'e3dc/mode'								, VARIABLETYPE_INTEGER, 'RSCP.EMS.Mode'  		,  1	, false, true],
			['EMS'		,151	,100	,'ems_coupling_mode'					, 'TAG_EMS_COUPLING_MODE'							, 'e3dc/coupling/mode'						, VARIABLETYPE_INTEGER, 'RSCP.Coupling.Mode' 	,  1	, false, true],
			['EMS'		,152	,100	,'system_peak_power'					, 'TAG_EMS_INSTALLED_PEAK_POWER'					, 'e3dc/system/installed_peak_power'		, VARIABLETYPE_INTEGER, ''						,  1	, false, true],

			// Battery
			['HEADER'	,200	,0		,'BATTERY'								, ''												, ''										, ''				, 	''						,  1	, false, false],
			['BAT'		,201	,200	,'battery_rsoc'							, 'TAG_BAT_RSOC'									, 'e3dc/battery/rsoc'						, VARIABLETYPE_FLOAT, 	'RSCP.SOC'				,  1	, false, true],
			['BAT'		,202	,200	,'battery_cycles'						, 'TAG_BAT_CHARGE_CYCLES'							, 'e3dc/battery/cycles'						, VARIABLETYPE_INTEGER, ''  		 			,  1	, false, true],
			['BAT'		,203	,200	,'battery_status'						, 'TAG_BAT_STATUS_CODE'								, 'e3dc/battery/status'						, VARIABLETYPE_INTEGER, ''  		 			,  1	, false, true],
			['BAT'		,204	,200	,'battery_soc'							, 'TAG_BAT_SOC'										, 'e3dc/battery/soc'						, VARIABLETYPE_FLOAT, 	'RSCP.SOC'				,  1	, false, true],
			
			// PVI
			['HEADER'	,300	,0		,'PVI'									, ''												, ''										, ''				, 	''						,  1	, false, false],
			['PVI'		,301	,300	,'pvi_power_string_1'					, 'TAG_PVI_DC_POWER'								, 'e3dc/pvi/power/string_1'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W' 			,  1	, false, true],
			['PVI'		,302	,300	,'pvi_power_string_2'					, 'TAG_PVI_DC_POWER'								, 'e3dc/pvi/power/string_2'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W' 			,  1	, false, true],
			['PVI'		,303	,300	,'pvi_power_string_1'					, 'TAG_PVI_DC_POWER'								, 'e3dc/pvi/power/string_1'					, VARIABLETYPE_FLOAT,	'RSCP.Power.W'			,  1	, false, true],
			['PVI'		,304	,300	,'pvi_power_string_2'					, 'TAG_PVI_DC_POWER'								, 'e3dc/pvi/power/string_2'					, VARIABLETYPE_FLOAT,	'RSCP.Power.W'			,  1	, false, true],
			['PVI'		,305	,300	,'pvi_voltage_string_1'					, 'TAG_PVI_DC_VOLTAGE'								, 'e3dc/pvi/voltage/string_1'				, VARIABLETYPE_FLOAT,	'~Volt'					,  1	, false, true],
			['PVI'		,306	,300	,'pvi_voltage_string_2'					, 'TAG_PVI_DC_VOLTAGE'								, 'e3dc/pvi/voltage/string_2'				, VARIABLETYPE_FLOAT,	'~Volt'					,  1	, false, true],
			['PVI'		,307	,300	,'pvi_current_string_1'					, 'TAG_PVI_DC_CURRENT'								, 'e3dc/pvi/current/string_1'				, VARIABLETYPE_FLOAT,	'~Ampere'				,  1	, false, true],
			['PVI'		,308	,300	,'pvi_current_string_2'					, 'TAG_PVI_DC_CURRENT'								, 'e3dc/pvi/current/string_2'				, VARIABLETYPE_FLOAT,	'~Ampere'				,  1	, false, true],
			['PVI'		,309	,300	,'pvi_energy_all_string_1'				, 'TAG_PVI_DC_STRING_ENERGY_ALL'					, 'e3dc/pvi/energy_all/string_1'			, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
			['PVI'		,310	,300	,'pvi_energy_all_string_2'				, 'TAG_PVI_DC_STRING_ENERGY_ALL'					, 'e3dc/pvi/energy_all/string_2'			, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
			['PVI'		,311	,300	,'pvi_power_L1'							, 'TAG_PVI_AC_POWER'								, 'e3dc/pvi/power/L1'						, VARIABLETYPE_FLOAT,	'RSCP.Power.W'			,  1	, false, true],
			['PVI'		,312	,300	,'pvi_power_L2'							, 'TAG_PVI_AC_POWER'								, 'e3dc/pvi/power/L2'						, VARIABLETYPE_FLOAT,	'RSCP.Power.W'			,  1	, false, true],
			['PVI'		,313	,300	,'pvi_power_L3'							, 'TAG_PVI_AC_POWER'								, 'e3dc/pvi/power/L3'						, VARIABLETYPE_FLOAT,	'RSCP.Power.W'			,  1	, false, true],
			['PVI'		,314	,300	,'pvi_voltage_L1'						, 'TAG_PVI_AC_VOLTAGE'								, 'e3dc/pvi/voltage/L1'						, VARIABLETYPE_FLOAT,	'~Volt'					,  1	, false, true],
			['PVI'		,315	,300	,'pvi_voltage_L2'						, 'TAG_PVI_AC_VOLTAGE'								, 'e3dc/pvi/voltage/L2'						, VARIABLETYPE_FLOAT,	'~Volt'					,  1	, false, true],
			['PVI'		,316	,300	,'pvi_voltage_L3'						, 'TAG_PVI_AC_VOLTAGE'								, 'e3dc/pvi/voltage/L3'						, VARIABLETYPE_FLOAT,	'~Volt'					,  1	, false, true],
			['PVI'		,317	,300	,'pvi_current_L1'						, 'TAG_PVI_AC_CURRENT'								, 'e3dc/pvi/current/L1'						, VARIABLETYPE_FLOAT,	'~Ampere'				,  1	, false, true],
			['PVI'		,318	,300	,'pvi_current_L2'						, 'TAG_PVI_AC_CURRENT'								, 'e3dc/pvi/current/L2'						, VARIABLETYPE_FLOAT,	'~Ampere'				,  1	, false, true],
			['PVI'		,319	,300	,'pvi_current_L3'						, 'TAG_PVI_AC_CURRENT'								, 'e3dc/pvi/current/L3'						, VARIABLETYPE_FLOAT,	'~Ampere'				,  1	, false, true],
			['PVI'		,320	,300	,'pvi_apparent_power_L1'				, 'TAG_PVI_AC_APPARENTPOWER'						, 'e3dc/pvi/apparent_power/L1'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
			['PVI'		,321	,300	,'pvi_apparent_power_L2'				, 'TAG_PVI_AC_APPARENTPOWER'						, 'e3dc/pvi/apparent_power/L2'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
			['PVI'		,322	,300	,'pvi_apparent_power_L3'				, 'TAG_PVI_AC_APPARENTPOWER'						, 'e3dc/pvi/apparent_power/L3'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
			['PVI'		,323	,300	,'pvi_reactive_power_L1'				, 'TAG_PVI_AC_REACTIVEPOWER'						, 'e3dc/pvi/reactive_power/L1'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VAR'		,  1	, false, true],
			['PVI'		,324	,300	,'pvi_reactive_power_L2'				, 'TAG_PVI_AC_REACTIVEPOWER'						, 'e3dc/pvi/reactive_power/L2'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VAR'		,  1	, false, true],
			['PVI'		,325	,300	,'pvi_reactive_power_L3'				, 'TAG_PVI_AC_REACTIVEPOWER'						, 'e3dc/pvi/reactive_power/L3'				, VARIABLETYPE_FLOAT,	'RSCP.Power.VAR'		,  1	, false, true],
//			['PVI'		,326	,300	,'pvi_energy_all_L1'					, 'TAG_PVI_AC_ENERGY_ALL'							, 'e3dc/pvi/energy_all/L1'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,327	,300	,'pvi_energy_all_L2'					, 'TAG_PVI_AC_ENERGY_ALL'							, 'e3dc/pvi/energy_all/L2'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,328	,300	,'pvi_energy_all_L3'					, 'TAG_PVI_AC_ENERGY_ALL'							, 'e3dc/pvi/energy_all/L3'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,329	,300	,'pvi_max_apparent_power_L1'			, 'TAG_PVI_AC_MAX_APPARENTPOWER'					, 'e3dc/pvi/max_apparent_power/L1'			, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
//			['PVI'		,330	,300	,'pvi_max_apparent_power_L2'			, 'TAG_PVI_AC_MAX_APPARENTPOWER'					, 'e3dc/pvi/max_apparent_power/L2'			, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
//			['PVI'		,331	,300	,'pvi_max_apparent_power_L3'			, 'TAG_PVI_AC_MAX_APPARENTPOWER'					, 'e3dc/pvi/max_apparent_power/L3'			, VARIABLETYPE_FLOAT,	'RSCP.Power.VA'			,  1	, false, true],
//			['PVI'		,332	,300	,'pvi_energy_day_L1'					, 'TAG_PVI_AC_ENERGY_DAY'							, 'e3dc/pvi/energy_day/L1'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,333	,300	,'pvi_energy_day_L2'					, 'TAG_PVI_AC_ENERGY_DAY'							, 'e3dc/pvi/energy_day/L2'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,334	,300	,'pvi_energy_day_L3'					, 'TAG_PVI_AC_ENERGY_DAY'							, 'e3dc/pvi/energy_day/L3'					, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,335	,300	,'pvi_energy_grid_consumption_L1'		, 'TAG_PVI_AC_ENERGY_GRID_CONSUMPTION'				, 'e3dc/pvi/energy_grid_consumption/L1'		, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,336	,300	,'pvi_energy_grid_consumption_L2'		, 'TAG_PVI_AC_ENERGY_GRID_CONSUMPTION'				, 'e3dc/pvi/energy_grid_consumption/L2'		, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
//			['PVI'		,337	,300	,'pvi_energy_grid_consumption_L3'		, 'TAG_PVI_AC_ENERGY_GRID_CONSUMPTION'				, 'e3dc/pvi/energy_grid_consumption/L3'		, VARIABLETYPE_FLOAT,	'~Electricity.Wh'		,  1	, false, true],
			['PVI'		,338	,300	,'pvi_frequency'						, 'TAG_PVI_AC_FREQUENCY'							, 'e3dc/pvi/frequency'						, VARIABLETYPE_FLOAT,	'~Hertz.50'				,  1	, false, true],
//			['PVI'		,340	,300	,'pvi_on_grid'							, 'TAG_PVI_DATA'									, 'e3dc/pvi/on_grid'						, VARIABLETYPE_BOOLEAN,	'RSCP.YesNo'			,  1	, false, true],

			// Wallbox
			['HEADER'	,400	,0 		,'WALLBOX'								, ''												, ''										, ''				, 	''						,  1	, false, false],
			['WB'      ,401    ,400    ,'wb_all_power'							, 'TAG_EMS_POWER_WB_ALL'							, 'e3dc/wallbox/power/total'				, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
			['WB'      ,402    ,400    ,'wb_all_solar'							, 'TAG_EMS_POWER_WB_SOLAR'							, 'e3dc/wallbox/power/solar'				, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
			['WB'      ,403    ,400    ,'wb_battery_to_car_mode'				, 'TAG_EMS_BATTERY_TO_CAR_MODE'						, 'e3dc/wallbox/discharge_battery_to_car'	, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],
			['WB'      ,404    ,400    ,'wb_battery_before_car_mode'			, 'TAG_EMS_BATTERY_BEFORE_CAR_MODE'					, 'e3dc/wallbox/charge_battery_before_car'	, VARIABLETYPE_BOOLEAN, 'RSCP.ChargePrio'		,  1    , true,  true],
			['WB'      ,405    ,400    ,'wb_device_state'						, 'TAG_WB_DEVICE_STATE'								, 'e3dc/wallbox/status'						, VARIABLETYPE_BOOLEAN,	'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,408    ,400    ,'wb_max_current'						, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/max_current'				, VARIABLETYPE_INTEGER, 'RSCP.Current.A'		,  1    , true,  true],
			['WB'      ,409    ,400    ,'wb_plugged'							, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/plugged'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,410    ,400    ,'wb_locked'								, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/locked'						, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,411    ,400    ,'wb_charging'							, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/charging'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],
			['WB'      ,412    ,400    ,'wb_canceled'							, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/suspended'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,413    ,400    ,'wb_sun_mode'							, 'TAG_WB_EXTERN_DATA'								, 'e3dc/wallbox/sun_mode'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],
			['WB'      ,414    ,400    ,'wb_battery_discharge_until'			, 'TAG_EMS_GET_WB_DISCHARGE_BAT_UNTIL'				, 'e3dc/wallbox/discharge_battery_until'	, VARIABLETYPE_INTEGER, '~Intensity.100'		,  1    , true,  true],
			['WB'      ,415    ,400    ,'wb_disable_battery_at_mix_mode'		, 'TAG_EMS_GET_WALLBOX_ENFORCE_POWER_ASSIGNMENT'	, 'e3dc/wallbox/disable_battery_at_mix_mode', VARIABLETYPE_BOOLEAN, 'RSCP.YesNo' 			,  1    , true,  true],
			['WB'      ,416    ,400    ,'wb_number_used_phases'					, 'TAG_WB_NUMBER_PHASES'							, 'e3dc/wallbox/number_phases'				, VARIABLETYPE_INTEGER, 'RSCP.WB.Phases'		,  1    , false, true],
			['WB'      ,417    ,400    ,'wb_index'								, 'TAG_WB_INDEX'									, 'e3dc/wallbox/index'						, VARIABLETYPE_INTEGER, ''						,  1    , true,  true],	

			['WB'      ,418    ,400    ,'wb_energy_all'							, 'TAG_WB_ENERGY_ALL'								, 'e3dc/wallbox/energy/total'				, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,419    ,400    ,'wb_last_energy_all'					, 'IDX_WALLBOX_LAST_ENERGY_ALL'						, 'e3dc/wallbox/energy/last_charging/total'	, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,420    ,400    ,'wb_energy_solar'						, 'TAG_WB_ENERGY_SOLAR'								, 'e3dc/wallbox/energy/solar'				, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,421    ,400    ,'wb_last_energy_solar'					, 'IDX_WALLBOX_LAST_ENERGY_SOLAR'					, 'e3dc/wallbox/energy/last_charging/solar'	, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,422    ,400    ,'wb_energy_l1'							, 'TAG_WB_PM_ENERGY_L1'								, 'e3dc/wallbox/energy/L1'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,423    ,400    ,'wb_energy_l2'							, 'TAG_WB_PM_ENERGY_L2'								, 'e3dc/wallbox/energy/L2'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,424    ,400    ,'wb_energy_l3'							, 'TAG_WB_PM_ENERGY_L3'								, 'e3dc/wallbox/energy/L3'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	

			['WB'      ,425    ,400    ,'wb_key_state'							, 'TAG_WB_KEY_STATE'								, 'e3dc/wallbox/key_state'					, VARIABLETYPE_BOOLEAN, '~Switch'				,  1    , false, true],
			['WB'      ,426    ,400    ,'wb_phases_l1'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'e3dc/wallbox/phases/L1'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,427    ,400    ,'wb_phases_l2'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'e3dc/wallbox/phases/L2'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
			['WB'      ,428    ,400    ,'wb_phases_l3'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'e3dc/wallbox/phases/L3'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],

			['WB'      ,429    ,400    ,'wb_all_power_l1'						, 'TAG_EMS_POWER_WB_ALL'							, 'e3dc/wallbox/power/L1'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
			['WB'      ,430    ,400    ,'wb_all_power_l2'						, 'TAG_EMS_POWER_WB_ALL'							, 'e3dc/wallbox/power/L2'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
			['WB'      ,431    ,400    ,'wb_all_power_l3'						, 'TAG_EMS_POWER_WB_ALL'							, 'e3dc/wallbox/power/L3'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
			['WB'      ,432    ,400    ,'wb_soc'								, 'TAG_WB_SOC'										, 'e3dc/wallbox/soc'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent'			,  1    , false, true],

			['WB'      ,433    ,400    ,'wb_energy_day_all'						, 'IDX_WALLBOX_DAY_ENERGY_ALL'						, 'e3dc/wallbox/energy/day/total'			, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
			['WB'      ,434    ,400    ,'wb_energy_day_solar'					, 'IDX_WALLBOX_DAY_ENERGY_SOLAR'					, 'e3dc/wallbox/day/solar'			, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	

			// settings
			['HEADER'	,700	,0 		,'LIMITER'								, ''												, ''										, ''				, 	''						,  1	, false, false],
			['LIM'       ,701    ,700    ,'lim_limit_charge'					, 'IDX_LIMIT_CHARGE_SOC'							, 'e3dc/limit/charge/soc'				, VARIABLETYPE_INTEGER, '~Intensity.100'		,  1    , true,  true],	
			['LIM'       ,702    ,700    ,'lim_limit_discharge'					, 'IDX_LIMIT_DISCHARGE_SOC'							, 'e3dc/limit/discharge/soc'			, VARIABLETYPE_INTEGER, '~Intensity.100'		,  1    , true,  true],	
			['LIM'       ,703    ,700    ,'lim_limit_charge_durable'			, 'IDX_LIMIT_CHARGE_DURABLE'						, 'e3dc/limit/charge/durable'			, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],	
			['LIM'       ,704    ,700    ,'lim_limit_discharge_durable'			, 'IDX_LIMIT_DISCHARGE_DURABLE'						, 'e3dc/limit/discharge/durable'		, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],	
			['LIM'       ,705    ,700    ,'lim_limit_discharge_by_home_power'	, 'IDX_LIMIT_DISCHARGE_BY_HOME_POWER'				, 'e3dc/limit/discharge/by_home_power'	, VARIABLETYPE_INTEGER, 'RSCP.Power.W.i'		,  1    , true,  true],	


			// DATABASE VALUES
			['HEADER'	,800	,0 		,'DATABASE'								, ''												, ''										, ''				, 	''						,  1	, false, false],
			['DB'		,801	,800	,'today_solar_energy'					, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/solar/energy'						, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,802	,800	,'today_add_energy'						, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/pm_1/energy'						, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  -1	, false, true],
			['DB'		,803	,800	,'today_battery_energy_charge'			, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/battery/energy/charge'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,804	,800	,'today_battery_energy_discharge'		, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/battery/energy/discharge'			, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,805	,800	,'today_home_energy'					, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/home/energy'						, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,806	,800	,'today_grid_energy_in'					, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/grid/energy/in'						, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,807	,800	,'today_grid_energy_out'				, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/grid/energy/out'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,808	,800	,'today_autarky'						, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/autarky'							, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,809	,800	,'today_consumed_production'			, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/consumed'							, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,811	,800	,'yesterday_solar_energy'				, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/solar/energy'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,812	,800	,'yesterday_add_energy'					, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/pm_1/energy'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  -1	, false, true],
			['DB'		,813	,800	,'yesterday_battery_energy_charge'		, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/battery/energy/charge'	, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,814	,800	,'yesterday_battery_energy_discharge'	, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/battery/energy/discharge'	, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,815	,800	,'yesterday_home_energy'				, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/home/energy'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,816	,800	,'yesterday_grid_energy_in'				, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/grid/energy/in'			, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,817	,800	,'yesterday_grid_energy_out'			, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/grid/energy/out'			, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,818	,800	,'yesterday_autarky'					, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/autarky'					, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,819	,800	,'yesterday_consumed_production'		, 'TAG_DB_HISTORY_DATA_DAY'							, 'e3dc/yesterday/consumed'					, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,821	,800	,'week_solar_energy'					, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/solar/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,823	,800	,'week_battery_energy_charge'			, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/battery/energy/charge'			, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,824	,800	,'week_battery_energy_discharge'		, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/battery/energy/discharge'		, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,825	,800	,'week_home_energy'						, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/home/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,826	,800	,'week_grid_energy_in'					, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/grid/energy/in'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,827	,800	,'week_grid_energy_out'					, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/grid/energy/out'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,828	,800	,'week_autarky'							, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/autarky'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,829	,800	,'week_consumed_production'				, 'TAG_DB_HISTORY_DATA_WEEK'						, 'e3dc/week/consumed'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,831	,800	,'month_solar_energy'					, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/solar/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,833	,800	,'month_battery_energy_charge'			, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/battery/energy/charge'		, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,834	,800	,'month_battery_energy_discharge'		, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/battery/energy/discharge'		, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,835	,800	,'month_home_energy'					, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/home/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,836	,800	,'month_grid_energy_in'					, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/grid/energy/in'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,837	,800	,'month_grid_energy_out'				, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/grid/energy/out'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,838	,800	,'month_autarky'						, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/autarky'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,839	,800	,'month_consumed_production'			, 'TAG_DB_HISTORY_DATA_MONTH'						, 'e3dc/month/consumed'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,841	,800	,'year_solar_energy'					, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/solar/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,843	,800	,'year_battery_energy_charge'			, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/battery/energy/charge'			, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,844	,800	,'year_battery_energy_discharge'		, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/battery/energy/discharge'		, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,845	,800	,'year_home_energy'						, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/home/energy'					, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,846	,800	,'year_grid_energy_in'					, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/grid/energy/in'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,847	,800	,'year_grid_energy_out'					, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/grid/energy/out'				, VARIABLETYPE_FLOAT, 	'~Electricity' 			,  1	, false, true],
			['DB'		,848	,800	,'year_autarky'							, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/autarky'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],
			['DB'		,849	,800	,'year_consumed_production'				, 'TAG_DB_HISTORY_DATA_YEAR'						, 'e3dc/year/consumed'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent' 			,  1	, false, true],

			// INFO
			['HEADER'	,900	,0		,'INFO'		 							, ''												, ''										, ''				, 	''						,  1	, false, false],
			['INFO'		,901	,900	,'system_software'						, 'TAG_INFO_SW_RELEASE'								, 'e3dc/system/software'					, VARIABLETYPE_STRING, 	''  		 			,  1	, false, true],
			['INFO'		,902	,900	,'RSCP2MQTT Version'					, ''												, 'e3dc/rscp2mqtt/version'					, VARIABLETYPE_STRING, 	''  		 			,  1	, false, true],
			['INFO'		,903	,900	,'RSCP2MQTT Status'						, ''												, 'e3dc/rscp2mqtt/status'					, VARIABLETYPE_STRING, 	''  		 			,  1	, false, true],

			// BATTERY MODULS DC (# as Index for more Moduls)
			// IDENT Colums must have the # as WIldcard for the index. MQTT must have the WIldcard Pattern [1-9] for the possible Index Numbers
			['HEADER'	,10000	,0		,'BATTERY MODULS'		 				, ''												, ''										, ''				, 	''						,  1	, false, false],
			['DCB'		,10001	,10000	,'dcb_module_#_soc'						, 'TAG_BAT_DCB_SOC' 								, 'e3dc/battery/dcb/[1-9]/soc'				, VARIABLETYPE_FLOAT, 	'RSCP.Percent'  		,  1	, false, true],
			['DCB'		,10002	,10000	,'dcb_module_#_soh'						, 'TAG_BAT_DCB_SOH' 								, 'e3dc/battery/dcb/[1-9]/soh'				, VARIABLETYPE_FLOAT, 	'RSCP.Percent'  		,  1	, false, true],
			['DCB'		,10003	,10000	,'dcb_module_#_cycles'					, 'TAG_BAT_DCB_CYCLE_COUNT'							, 'e3dc/battery/dcb/[1-9]/cycles'			, VARIABLETYPE_INTEGER,	''				  		,  1	, false, true],
			['DCB'		,10004	,10000	,'dcb_module_#_current'					, 'TAG_BAT_DCB_CURRENT	'							, 'e3dc/battery/dcb/[1-9]/current'			, VARIABLETYPE_FLOAT,	'~Ampere'		  		,  1	, false, true],
			['DCB'		,10050	,10000	,'dcb_module_#_manufacture_name'		, 'TAG_BAT_DCB_MANUFACTURE_NAME'					, 'e3dc/battery/dcb/[1-9]/manufacture_name'	, VARIABLETYPE_STRING,	''				  		,  1	, false, true],
			['DCB'		,10051	,10000	,'dcb_module_#_serialno'				, 'TAG_BAT_DCB_SERIALNO'							, 'e3dc/battery/dcb/[1-9]/serial_number2'	, VARIABLETYPE_STRING,	''				  		,  1	, false, true],

		];
	}	
	