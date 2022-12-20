<?php

declare(strict_types=1);
require_once __DIR__ . '/../libs/helper.php';
require_once __DIR__ . '/../libs/vendor/SymconModulHelper/VariableProfileHelper.php';
class IPS_Volumio extends IPSModule
{
    use VariableProfileHelper;
    use
        VoluminoHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        $this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');

        $this->RegisterPropertyString('RadioSender', '[]');

        $this->RegisterControls();

        $this->RegisterPropertyString('MQTTTopic', '');
        $this->RegisterVariableString('Volumio_Title', $this->Translate('Title'), '');
        $this->RegisterVariableString('Volumio_Artist', $this->Translate('Artist'), '');
        $this->RegisterVariableBoolean('Volumio_Power', $this->Translate('Power'), '~Switch');
        $this->RegisterVariableInteger('Volumio_Volume', $this->Translate('Volume'), '~Intensity.100');
        $this->RegisterVariableInteger('Volumio_VolumeUpDown', $this->Translate('Volume (Up/Down)'), 'Volumio.VolumeUpDown');
        $this->RegisterVariableInteger('Volumio_VolumePush', $this->Translate('Volume (Push)'), 'Volumio.VolumePush');
        $this->RegisterVariableBoolean('Volumio_Mute', $this->Translate('Mute'), '~Switch');
        $this->RegisterVariableInteger('Volumio_Controls', $this->Translate('Controls'), 'Volumio.Controls');
        //$this->UpdateRadioSender();
        if (!IPS_VariableProfileExists('Volumio.RadioSender.' . $this->InstanceID)) {
            IPS_CreateVariableProfile('Volumio.RadioSender.' . $this->InstanceID, 1);
        }
        $this->RegisterVariableInteger('Volumio_RadioSender', $this->Translate('Radio Sender'), 'Volumio.RadioSender.' . $this->InstanceID);

        $this->EnableAction('Volumio_Power');
        $this->EnableAction('Volumio_Volume');
        $this->EnableAction('Volumio_VolumeUpDown');
        $this->EnableAction('Volumio_VolumePush');
        $this->EnableAction('Volumio_Mute');
        $this->EnableAction('Volumio_Controls');
        $this->EnableAction('Volumio_RadioSender');
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
        $this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
        //Setze Filter für ReceiveData
        $MQTTTopic = $this->ReadPropertyString('MQTTTopic');
        $this->SetReceiveDataFilter('.*' . $MQTTTopic . '.*');
    }

    public function ReceiveData($JSONString)
    {
        $this->SendDebug('JSON', $JSONString, 0);
        if (!empty($this->ReadPropertyString('MQTTTopic'))) {
            $Buffer = json_decode($JSONString);

            //Für MQTT Fix in IPS Version 6.3
            if (IPS_GetKernelDate() > 1670886000) {
                $Buffer->Payload = utf8_decode($Buffer->Payload);
            }

            $this->SendDebug('MQTT Topic', $Buffer->Topic, 0);

            if (property_exists($Buffer, 'Topic')) {
                $this->SendDebug('Power Topic', $Buffer->Topic, 0);
                $this->SendDebug('Power Payload', $Buffer->Payload, 0);

                if (fnmatch('*/status/volume/mute', $Buffer->Topic)) {
                    if ($Buffer->Payload == 'true') {
                        SetValue($this->GetIDForIdent('Volumio_Mute'), true);
                    } else {
                        SetValue($this->GetIDForIdent('Volumio_Mute'), false);
                    }
                }
                if (fnmatch('*/status/volume', $Buffer->Topic)) {
                    SetValue($this->GetIDForIdent('Volumio_Volume'), $Buffer->Payload);
                }
                if (fnmatch('*/status/info', $Buffer->Topic)) {
                    $Payload = json_decode($Buffer->Payload);
                    switch ($Payload->status) {
                        case 'stop':
                            SetValue($this->GetIDForIdent('Volumio_Controls'), 4);
                            break;
                        case 'play':
                            SetValue($this->GetIDForIdent('Volumio_Controls'), 2);
                            break;
                        case 'prev':
                            SetValue($this->GetIDForIdent('Volumio_Controls'), 1);
                            break;
                        case 'next':
                            SetValue($this->GetIDForIdent('Volumio_Controls'), 5);
                            break;
                        case 'pause':
                            SetValue($this->GetIDForIdent('Volumio_Controls'), 3);
                            break;
                    }
                    SetValue($this->GetIDForIdent('Volumio_Title'), $Payload->title);
                    SetValue($this->GetIDForIdent('Volumio_Artist'), $Payload->artist);
                }
            }
        }
    }

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'Volumio_RadioSender':
                $this->PlayRadio($Value);
                break;
            case 'Volumio_Power':
                $this->Power($Value);
                break;
            case 'Volumio_Volume':
                $this->Volume($Value);
                break;
            case 'Volumio_VolumeUpDown':
                switch ($Value) {
                    case 1:
                        $this->VolumeUp();
                        break;
                    case 2:
                        $this->VolumeDown();
                        break;
                }
                break;
            case 'Volumio_VolumePush':
                switch ($Value) {
                    case 1:
                        $this->VolumePushPlus();
                        break;
                    case 2:
                        $this->VolumePushMinus();
                        break;
                }
                break;
            case 'Volumio_Mute':
                $this->Mute($Value);
                break;
            case 'Volumio_Controls':
                switch ($Value) {
                    case 1:
                        $this->Prev();
                        break;
                    case 2:
                        $this->Play();
                        break;
                    case 3:
                        $this->Pause();
                        break;
                    case 4:
                        $this->Stop();
                        break;
                    case 5:
                        $this->Next();
                        break;
                }
                break;
        }
    }
}
