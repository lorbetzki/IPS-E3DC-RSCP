<?php

declare(strict_types=1);
//require_once __DIR__ . '/../libs/RSCPModule.php';


	class RSCP2MQTTwallboxaddon extends IPSModule
	{	
		//Topic als Konstante definieren
		const TOPIC = 'e3dc/wallbox/';

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');

			$this->RegisterPropertyInteger('Wallbox_Index', 1);
			$this->RegisterPropertyBoolean('EmulateState', true);
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

			$Variables = [];
        	foreach (static::$Variables as $Pos => $Variable)
			 {	
				$Variables[] = [
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
					'Keep'         	=> $Variable[10]
				];
        	}	
			$this->RegisterPropertyString('Variables', json_encode($Variables));
			$this->SendDebug(__FUNCTION__,json_encode($Variables),0);
			
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
			
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();

			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
			
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

 			//Setze Filter für ReceiveData
			$this->SetReceiveDataFilter('.*' . static::TOPIC . $WBIndex .'/.*');

			$this->registerVariables();
		}

		public function ReceiveData($JSONString)
		{
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');
			
			$this->SendDebug('JSON', $JSONString, 0);
        	if (!empty(static::TOPIC)) {

				if ($JSONString == '') {
					$this->log('No JSON');
					return true;
				}

				$data = json_decode($JSONString);

				switch ($data->DataID) {
					case '{7F7632D9-FA40-4F38-8DEA-C83CD4325A32}': // MQTT Server
						$Buffer = $data;
						break;
					default:
						$this->LogMessage('Invalid Parent', KL_ERROR);
						return;
				}
				$this->SendDebug('MQTT Topic', $Buffer->Topic, 0);

				if (property_exists($Buffer, 'Topic')) {
					$Variables = json_decode($this->ReadPropertyString('Variables'), true);
					foreach ($Variables as $Variable) {
						if ($Variable['Keep']){
							// create Var for User Wallbox ID
							$VarMQTT = static::TOPIC.$WBIndex."/".$Variable['MQTT'];
							
							if (fnmatch($VarMQTT, $Buffer->Topic)) {
								$this->SendDebug($VarMQTT, $Buffer->Payload, 0);
								if ($Variable['Factor'] == 1){
									$this->SetValue($Variable['Ident'], $Buffer->Payload); 
								} 
								else {
									$this->SetValue($Variable['Ident'], $Buffer->Payload * $Variable['Factor']); 
								}   	
							} 
						}  
					}
				}
			}
		}

		public function GetConfigurationForm()
		{
			$jsonform = json_decode(file_get_contents(__DIR__."/../RSCP2MQTT_wallbox_addon/form.json"), true);
			$this->SendDebug(__FUNCTION__,json_encode($jsonform),0);
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');
			$this->SendDebug(__FUNCTION__,static::TOPIC.$WBIndex,0);

			// create Values for List dynamically
			$ListValues = [];
			foreach (static::$Variables as $Pos => $Variable) {
				$id          	= $Variable[1];
				$parent			= $Variable[2];
				$Namespace	  	= $this->Translate($Variable[0]);
				$Ident        	= str_replace(' ', '', $Variable[3]);
				$Name         	= $this->Translate($Variable[3]);
				$Tag		   	= $Variable[4];
				$MQTT		   	= $Variable[5];
				$VarType      	= $Variable[6];
				$Profile      	= $Variable[7];
				$Factor       	= $Variable[8];
				$Action       	= $Variable[9];
				$Keep        	= $Variable[10];

				//$ListValues[] = ["id"=>"$id", "parent"=>"$parent", "Namespace"=>"$Namespace", "Ident"=>"$Ident", "Name"=>"$Name", "Tag"=>"$Tag", "MQTT"=>"$MQTT", "VarType"=>"$VarType", "Profile"=>"$Profile", "Factor"=>"$Factor", "Action"=>"$Action", "Keep"=>"$Keep", "rowColor"=>"$rowColor", "editable"=>"$editable" ];
				$ListValues[] = ["id"=>"$id", "parent"=>"$parent", "Namespace"=>"$Namespace", "Ident"=>"$Ident", "Name"=>"$Name", "Tag"=>"$Tag", "MQTT"=>"$MQTT", "VarType"=>"$VarType", "Profile"=>"$Profile", "Factor"=>"$Factor", "Action"=>"$Action", "Keep"=>"$Keep"];

			}
				
			$this->SendDebug(__FUNCTION__.' Write Values for List', json_encode($ListValues),0)	;

			$jsonform["elements"][0]['values'] = $ListValues;

			return json_encode($jsonform);
		}

		public function set_wb_max_current(int $value)
		{
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

			$Topic = 'e3dc/set/wallbox/'.$WBIndex.'/max_current';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_sun_mode(bool $value)
		{
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

			$Topic = 'e3dc/set/wallbox/'.$WBIndex.'/sun_mode';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_charging(bool $value)
		{
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

			$Topic = 'e3dc/set/wallbox/'.$WBIndex.'/toggle';
			if ($value)
				$Payload = '1';
			else
				$Payload = '0';	
			$this->sendMQTT($Topic, $Payload);	
		}

		public function set_wb_number_of_phases(int $value)
		{            
			$WBIndex = $this->ReadPropertyInteger('Wallbox_Index');

			$Topic = 'e3dc/set/wallbox/'.$WBIndex.'/number_phases';
			$Payload = strval($value);
			$this->sendMQTT($Topic, $Payload);	
		}

		public function RequestAction($Ident, $Value)
		{
			switch ($Ident){
				
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

				case "wb_number_phases":
					$this->set_wb_number_of_phases($Value);
					if ($this->ReadPropertyBoolean('EmulateState')){$this->SetValue($Ident, $Value);}
				break;		

				default:
					throw new Exception("Invalid Ident");

			}
		}
		
		private function registerVariables()
		{
			$this->SendDebug(__FUNCTION__, $this->ReadPropertyString('Variables'), 0);
			$Variables = json_decode($this->ReadPropertyString('Variables'), true);
			foreach ($Variables as $pos => $Variable) {
				@$this->MaintainVariable($Variable['Ident'], $Variable['Name'], $Variable['VarType'], $Variable['Profile'], $Variable['Pos'], $Variable['Keep']);
				if ($Variable['Action'] && $Variable['Keep']) 
				{
					$this->EnableAction($Variable['Ident']);
				}
			}						
			$this->SendDebug('Variablen_Reg_2_Color', json_encode($Variables), 0);

		}
		
		// Mapping Definition für die MQTT Werte - RSCP2MQTT
		public static $Variables = [
		// 	NSPACE  	POS	 PARENT		IDENT									RSCP TAG 											MQTT Topic									Variablen Typ			Var Profil	  			Faktor  ACTION  KEEP
		['HEADER'	,100	,0 		,'WALLBOX'								, ''												, ''										, ''				, 	''						,  1	, false, false],
		['WB'      ,101    ,100    ,'wb_all_power'							, 'TAG_EMS_POWER_WB_ALL'							, 'total/power'				, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
		['WB'      ,102    ,100    ,'wb_all_solar'							, 'TAG_EMS_POWER_WB_SOLAR'							, 'solar/power'				, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
		['WB'      ,105    ,100    ,'wb_device_state'						, 'TAG_WB_DEVICE_STATE'								, 'status'						, VARIABLETYPE_BOOLEAN,	'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,108    ,100    ,'wb_max_current'						, 'TAG_WB_EXTERN_DATA'								, 'max_current'				, VARIABLETYPE_INTEGER, 'RSCP.Current.A'		,  1    , true,  true],
		['WB'      ,109    ,100    ,'wb_plugged'							, 'TAG_WB_EXTERN_DATA'								, 'plugged'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,110    ,100    ,'wb_locked'								, 'TAG_WB_EXTERN_DATA'								, 'locked'						, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,111    ,100    ,'wb_charging'							, 'TAG_WB_EXTERN_DATA'								, 'charging'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],
		['WB'      ,112    ,100    ,'wb_canceled'							, 'TAG_WB_EXTERN_DATA'								, 'suspended'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,113    ,100    ,'wb_sun_mode'							, 'TAG_WB_EXTERN_DATA'								, 'sun_mode'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , true,  true],
		['WB'      ,116    ,100    ,'wb_number_used_phases'					, 'TAG_WB_NUMBER_PHASES'							, 'number_phases'				, VARIABLETYPE_INTEGER, 'RSCP.WB.Phases'		,  1    , false, true],

		['WB'      ,118    ,100    ,'wb_energy_all'							, 'TAG_WB_ENERGY_ALL'								, 'energy/total'				, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,119    ,100    ,'wb_last_energy_all'					, 'IDX_WALLBOX_LAST_ENERGY_ALL'						, 'energy/last_charging/total'	, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,120    ,100    ,'wb_energy_solar'						, 'TAG_WB_ENERGY_SOLAR'								, 'energy/solar'				, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,121    ,100    ,'wb_last_energy_solar'					, 'IDX_WALLBOX_LAST_ENERGY_SOLAR'					, 'energy/last_charging/solar'	, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,122    ,100    ,'wb_energy_l1'							, 'TAG_WB_PM_ENERGY_L1'								, 'energy/L1'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,123    ,100    ,'wb_energy_l2'							, 'TAG_WB_PM_ENERGY_L2'								, 'energy/L2'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,124    ,100    ,'wb_energy_l3'							, 'TAG_WB_PM_ENERGY_L3'								, 'energy/L3'					, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	

		['WB'      ,125    ,100    ,'wb_key_state'							, 'TAG_WB_KEY_STATE'								, 'key_state'					, VARIABLETYPE_BOOLEAN, '~Switch'				,  1    , false, true],
		['WB'      ,126    ,100    ,'wb_phases_l1'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'phases/L1'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,127    ,100    ,'wb_phases_l2'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'phases/L2'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],
		['WB'      ,128    ,100    ,'wb_phases_l3'							, 'TAG_WB_PM_ACTIVE_PHASES'							, 'phases/L3'					, VARIABLETYPE_BOOLEAN, 'RSCP.YesNo'			,  1    , false, true],

		['WB'      ,129    ,100    ,'wb_all_power_l1'						, 'TAG_EMS_POWER_WB_ALL'							, 'power/L1'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
		['WB'      ,130    ,100    ,'wb_all_power_l2'						, 'TAG_EMS_POWER_WB_ALL'							, 'power/L2'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
		['WB'      ,131    ,100    ,'wb_all_power_l3'						, 'TAG_EMS_POWER_WB_ALL'							, 'power/L3'					, VARIABLETYPE_FLOAT, 	'RSCP.Power.W'			,  1    , false, true],
		['WB'      ,132    ,100    ,'wb_soc'								, 'TAG_WB_SOC'										, 'soc'						, VARIABLETYPE_FLOAT, 	'RSCP.Percent'			,  1    , false, true],

		['WB'      ,133    ,100    ,'wb_energy_day_all'						, 'IDX_WALLBOX_DAY_ENERGY_ALL'						, 'energy/day/total'			, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	
		['WB'      ,134    ,100    ,'wb_energy_day_solar'					, 'IDX_WALLBOX_DAY_ENERGY_SOLAR'					, 'day/solar'			, VARIABLETYPE_FLOAT, '~Electricity.Wh'			,  1    , false,  true],	


		];
	}	
	