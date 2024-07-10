<?php

declare(strict_types=1);

require_once __DIR__ . '/Functions.php';
	class RSCPModule extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();
			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');

			$this->RegisterPropertyBoolean('Name', false);
			$this->RegisterPropertyBoolean('EmulateState', true);
			
			$Variables = [];
        	foreach (static::$Variables as $Pos => $Variable) {
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
			
			//Setze Filter für ReceiveData
			$this->SetReceiveDataFilter('.*' . static::TOPIC . '.*');
	
			$this->registerProfiles();
			$this->registerVariables();
			//$this->UpdateFormField('Variables', "value", $this->ReadAttributeString('Variables'));
		}

		public function ReceiveData($JSONString)
		{
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
							if (fnmatch( $Variable['MQTT'], $Buffer->Topic)) {
								$this->SendDebug($Variable['MQTT'], $Buffer->Payload, 0);
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

		protected function resetVariables()
		{
			$Variables = [];
        	foreach (static::$Variables as $Pos => $Variable) {
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
			$this->SendDebug(__FUNCTION__, json_encode($Variables) ,0 );
			$this->UpdateFormField('Variables', 'values', json_encode($Variables)); 
			return;
		}

		protected function update_Variable_position()
		{
			$Variables = json_decode($this->ReadPropertyString('Variables'), true);
			foreach ($Variables as $Variable) {
				if ($Variable['Keep']){
					if ( IPS_GetObjectIDByIdent($Variable['Ident'], $this->InstanceID) != false); {
						IPS_SetPosition(IPS_GetObjectIDByIdent($Variable['Ident'], $this->InstanceID), $Variable['id'] );
					}
				}
			}
		}

		protected function update_Variable_name()
		{
			$Variables = json_decode($this->ReadPropertyString('Variables'), true);
			foreach ($Variables as $Variable) {
				if ($Variable['Keep']){
					if ( IPS_GetObjectIDByIdent($Variable['Ident'], $this->InstanceID) != false); {
						IPS_SetName(IPS_GetObjectIDByIdent($Variable['Ident'], $this->InstanceID), $this->set_name($Variable['Namespace'], $Variable['Name']) );
					}
				}
			}
		}

		public function GetConfigurationForm()
		{
			$jsonform = json_decode(file_get_contents(__DIR__."/../RSCP2MQTT_Connect/form.json"), true);
			$this->SendDebug(__FUNCTION__,json_encode($jsonform),0);

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

		// Private & Protected Methods
		private function registerProfiles()
		{
			//Create required Profiles

			if (!IPS_VariableProfileExists('RSCP.Power.Mode')) {
				IPS_CreateVariableProfile('RSCP.Power.Mode', 1);
				IPS_SetVariableProfileIcon('RSCP.Power.Mode', 'Ok');
				IPS_SetVariableProfileAssociation("RSCP.Power.Mode", 0, "Auto/Normal", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Power.Mode", 1, "Idle", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Power.Mode", 2, "Entladen", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Power.Mode", 3, "Laden", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Power.Mode", 4, "Netz Laden", "", 0xFFFFFF);
			}
			if (!IPS_VariableProfileExists('RSCP.Coupling.Mode')) {
				IPS_CreateVariableProfile('RSCP.Coupling.Mode', 1);
				IPS_SetVariableProfileIcon('RSCP.Coupling.Mode', 'Ok');
				IPS_SetVariableProfileAssociation("RSCP.Coupling.Mode", 0, "DC", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Coupling.Mode", 1, "DC-MultiWR", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Coupling.Mode", 2, "AC", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Coupling.Mode", 3, "Hybrid", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.Coupling.Mode", 4, "Insel", "", 0xFFFFFF);
			}
			if (!IPS_VariableProfileExists('RSCP.EMS.Mode')) {
				IPS_CreateVariableProfile('RSCP.EMS.Mode', 1);
				IPS_SetVariableProfileIcon('RSCP.EMS.Mode', 'Ok');
				IPS_SetVariableProfileAssociation("RSCP.EMS.Mode", 0, "Idle", "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.EMS.Mode", 1, "Entladen", "", 0xFF0000);
				IPS_SetVariableProfileAssociation("RSCP.EMS.Mode", 2, "Laden", "", 0x008000);
			}
			if (!IPS_VariableProfileExists('RSCP.Power.W.i')) {
				IPS_CreateVariableProfile('RSCP.Power.W.i', 1);
				IPS_SetVariableProfileIcon('RSCP.Power.W.i', 'Energy');
				IPS_SetVariableProfileValues("RSCP.Power.W.i", 0, 50000, 500);
				IPS_SetVariableProfileText("RSCP.Power.W.i", "", " W");
			}
			if (!IPS_VariableProfileExists('RSCP.Power.W')) {
				IPS_CreateVariableProfile('RSCP.Power.W', 2);
				IPS_SetVariableProfileIcon('RSCP.Power.W', 'Energy');
				IPS_SetVariableProfileDigits("RSCP.Power.W", 0);
				IPS_SetVariableProfileValues("RSCP.Power.W", 0, 50000, 0 );
				IPS_SetVariableProfileText("RSCP.Power.W", "", " W");
			}
			if (!IPS_VariableProfileExists('RSCP.SOC')) {
				IPS_CreateVariableProfile('RSCP.SOC', 2);
				IPS_SetVariableProfileIcon('RSCP.SOC', 'Battery');
				IPS_SetVariableProfileDigits("RSCP.SOC", 1);
				IPS_SetVariableProfileValues("RSCP.SOC", 0, 100, 1);
				IPS_SetVariableProfileText("RSCP.SOC", "", "%");
			}
			if (!IPS_VariableProfileExists('RSCP.Percent')) {
				IPS_CreateVariableProfile('RSCP.Percent', 2);
				IPS_SetVariableProfileDigits("RSCP.Percent", 1);
				IPS_SetVariableProfileValues("RSCP.Percent", 0, 100, 1);
				IPS_SetVariableProfileText("RSCP.Percent", "", "%");
			}
			if (!IPS_VariableProfileExists('RSCP.Current.A')) {
				IPS_CreateVariableProfile('RSCP.Current.A', 1);
				IPS_SetVariableProfileIcon('RSCP.Current.A', '');
				IPS_SetVariableProfileValues("RSCP.Current.A", 6, 32, 1);
				IPS_SetVariableProfileText("RSCP.Current.A", "", " A");
			}
			if (!IPS_VariableProfileExists('RSCP.ChargePrio')) {
				IPS_CreateVariableProfile('RSCP.ChargePrio', 0);
				IPS_SetVariableProfileAssociation("RSCP.ChargePrio", 0, $this->Translate('wallbox first'), "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.ChargePrio", 1, $this->Translate('battery first'), "", 0xFFFFFF);
			}
			if (!IPS_VariableProfileExists('RSCP.WB.Phases')) {
				IPS_CreateVariableProfile('RSCP.WB.Phases', 1);
				IPS_SetVariableProfileValues("RSCP.WB.Phases", 1, 3, 1);
				IPS_SetVariableProfileAssociation("RSCP.WB.Phases", 1, $this->Translate('1 Phase'), "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.WB.Phases", 2, $this->Translate('2 Phases'), "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.WB.Phases", 3, $this->Translate('3 Phases'), "", 0xFFFFFF);
			}
			if (!IPS_VariableProfileExists('RSCP.YesNo')) {
				IPS_CreateVariableProfile('RSCP.YesNo', 0);
				IPS_SetVariableProfileAssociation("RSCP.YesNo", 0, $this->Translate('no'), "", 0xFFFFFF);
				IPS_SetVariableProfileAssociation("RSCP.YesNo", 1, $this->Translate('yes'), "", 0xFFFFFF);
			}
			if (!IPS_VariableProfileExists('RSCP.Power.VA')) {
				IPS_CreateVariableProfile('RSCP.Power.VA', 2);
				IPS_SetVariableProfileIcon('RSCP.Power.VA', 'Energy');
				IPS_SetVariableProfileDigits("RSCP.Power.VA", 1);
				IPS_SetVariableProfileValues("RSCP.Power.VA", 0, 50000, 0 );
				IPS_SetVariableProfileText("RSCP.Power.VA", "", " VA");
			}
			if (!IPS_VariableProfileExists('RSCP.Power.VAR')) {
				IPS_CreateVariableProfile('RSCP.Power.VAR', 2);
				IPS_SetVariableProfileIcon('RSCP.Power.VAR', 'Energy');
				IPS_SetVariableProfileDigits("RSCP.Power.VAR", 1);
				IPS_SetVariableProfileValues("RSCP.Power.VAR", 0, 50000, 0 );
				IPS_SetVariableProfileText("RSCP.Power.VAR", "", " VAR");
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
		private function set_name($ns , $name)
		{
			if ($this->ReadPropertyBoolean('Name')){
				return $ns.'_'.$name;
			}
			else{
				return $name;
			}
		}

		protected function sendMQTT($Topic, $Payload)
		{
			$mqtt['DataID'] = '{043EA491-0325-4ADD-8FC2-A30C8EEB4D3F}';
			$mqtt['PacketType'] = 3;
			$mqtt['QualityOfService'] = 0;
			$mqtt['Retain'] = false;
			$mqtt['Topic'] = $Topic;
			$mqtt['Payload'] = $Payload;
			$mqttJSON = json_encode($mqtt, JSON_UNESCAPED_SLASHES);
			$mqttJSON = json_encode($mqtt);
			$this->SendDebug(__FUNCTION__ . 'MQTT', $mqttJSON, 0);
			$result = @$this->SendDataToParent($mqttJSON);
			$this->SendDebug(__FUNCTION__ . 'MQTT', $result, 0);

			if ($result === false ) {
				$last_error = error_get_last();
				echo $last_error['message'];
			}
		}
	}	
	