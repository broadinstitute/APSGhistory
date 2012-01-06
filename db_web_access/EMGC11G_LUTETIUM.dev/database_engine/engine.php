<?php

require_once 'components/common.php'; // TODO: remove
require_once 'components/common_utils.php'; // TODO: remove
require_once 'components/error_utils.php'; // TODO: remove
require_once 'database_engine/commands.php';

abstract class ConnectionFactory
{
    abstract function CreateConnection($AConnectionParams);

    /**
     * @abstract
     * @param EngConnection $AConnection
     * @param string $ASQL
     * @return EngDataReader
     */
    abstract function CreateDataset($AConnection, $ASQL);

    public function CreateEngCommandImp()
    {
        return new EngCommandImp($this);
    }

    public function CreateSelectCommand()
    {
        return new SelectCommand($this->CreateEngCommandImp());
    }

    public function CreateUpdateCommand()
    {
        return new UpdateCommand($this->CreateEngCommandImp());
    }

    public function CreateInsertCommand()
    {
        return new InsertCommand($this->CreateEngCommandImp());
    }

    public function CreateDeleteCommand()
    {
        return new DeleteCommand($this->CreateEngCommandImp());
    }

    public function CreateCustomSelectCommand($sql)
    {
        return new CustomSelectCommand($sql, $this->CreateEngCommandImp());
    }

    public function CreateCustomUpdateCommand($sql)
    {
        if (is_array($sql))
            return new MultiStatementUpdateCommand($sql, $this->CreateEngCommandImp());
        else
            return new CustomUpdateCommand($sql, $this->CreateEngCommandImp());
    }

    public function CreateCustomInsertCommand($sql)
    {
        if (is_array($sql))
            return new MultiStatementInsertCommand($sql, $this->CreateEngCommandImp());
        else
            return new CustomInsertCommand($sql, $this->CreateEngCommandImp());
    }

    public function CreateCustomDeleteCommand($sql)
    {
        if (is_array($sql))
            return new MultiStatementDeleteCommand($sql, $this->CreateEngCommandImp());
        else
            return new CustomDeleteCommand($sql, $this->CreateEngCommandImp());
    }
}

abstract class EngConnection
{
    private $connectionParams;
    private $connected;

    public $OnAfterConnect;

    protected abstract function DoConnect();

    protected abstract function DoDisconnect();

    protected abstract function DoCreateDataReader($sql);

    public function ConnectionParam($paramName)
    {
        return isset($this->connectionParams[$paramName]) ? $this->connectionParams[$paramName] : '';
    }

    public function HasConnectionParam($paramName)
    {
        return isset($this->connectionParams[$paramName]);
    }

    protected function FormatConnectionParams()
    {
        return $this->ConnectionParam('server');
    }

    public function __construct($connectionParams)
    {
        $this->connectionParams = $connectionParams;
        $this->OnAfterConnect = new Event();
        $this->serverVersion = new SMVersion(0, 0);
    }

    public function CreateDataReader($sql)
    {
        return $this->DoCreateDataReader($sql);
    }

    public function GetConnectionHandle()
    {
        return null;
    }

    public function IsDriverSupported()
    {
        return true;
    }

    public function GetDriverNotSupportedMessage()
    {
        return '';
    }

    public function GetClientEncoding()
    {
        return $this->clientEncoding;
    }

    public function SetClientEncoding($value)
    {
        $this->clientEncoding = $value;
    }

    public function Connected()
    {
        return $this->connected;
    }

    protected function DoExecSQL($sql)
    { }

    public function ExecSQL($sql)
    {
        if (!$this->DoExecSQL($sql))
            RaiseError($this->LastError());
    }

    public abstract function ExecScalarSQL($sql);

    public function ExecQueryToArray($sql, &$array)
    {
        $dataReader = $this->CreateDataReader($sql);
        $dataReader->Open();

        while ($dataReader->Next())
        {
            $row = array();
            for ($i = 0; $i < $dataReader->FieldCount(); $i++)
            {
                $row[$dataReader->GetField($i)] =
                    $dataReader->GetFieldValueByName($dataReader->GetField($i));
            }
            $array[] = $row;
        }

        $dataReader->Close();
    }
    
    private function CheckDriverSupported()
    {
        if (!$this->IsDriverSupported())
        {
            RaiseError(sprintf('Could not connect to %s: %s',
                $this->FormatConnectionParams(),
                $this->LastError()
            ));
        }
    }

    public function SupportsLastInsertId()
    {
        return false;
    }

    public function GetLastInsertId()
    {
        return 0;
    }

    public function Connect()
    {
        if (!$this->Connected())
        {
            $this->CheckDriverSupported();
            
            $this->connected = $this->DoConnect();
            if(!$this->Connected())
            {
                RaiseError(sprintf('Could not connect to %s: %s',
                    $this->FormatConnectionParams(),
                    $this->LastError()
                ));
            }
            else
            {
                $this->OnAfterConnect->Fire(array(&$this));
            }
        }
    }

    public function Disconnect()
    {
        if ($this->Connected())
        {
            $this->DoDisconnect();
            $this->connected = false;
        }
    }

    public function DoLastError()
    {
        return '';
    }

    public function LastError()
    {
        if (!$this->IsDriverSupported())
            return $this->GetDriverNotSupportedMessage();
        else
            return $this->DoLastError();
    }

    /**
     * @return SMVersion
     */
    public function GetServerVersion()
    {
        return $this->serverVersion;
    }
}

abstract class EngDataReader
{
    private $sql;
    private $connection;
    private $fieldList;
    private $rowLimit;
    private $fieldInfos;

    public function __construct($connection, $sql)
    {
        $this->fieldInfos = array();
        $this->connection = $connection;
        $this->sql = $sql;
        $this->fieldList = array();
        $this->rowLimit = -1;
    }

    // <FieldList management>
    protected function FetchField()
    {
    }

    protected function FetchFields()
    {
        $Field = $this->FetchField();
        while ($Field)
        {
            $this->AddField($Field);
            $Field = $this->FetchField();
        }
    }

    protected function GetFieldIndexByName($fieldName)
    {
        return array_search($fieldName, $this->fieldList);
    }

    public function AddField($AField)
    {
        $this->fieldList[] = $AField;
    }

    function ClearFields()
    {
        $this->fieldList = array();
    }

    public function FieldCount()
    {
        return count($this->fieldList);
    }

    public function GetField($AIndex)
    {
        return $this->fieldList[$AIndex];
    }
    // </FieldList management>

    // <FieldInfoList management>
    public function AddFieldInfo($fieldInfo)
    {
        if (isset($fieldInfo->Alias))
            $this->fieldInfos[$fieldInfo->Alias] = $fieldInfo;
        else
            $this->fieldInfos[$fieldInfo->Name] = $fieldInfo;
    }

    public function GetFieldInfoByFieldName(&$fieldName)
    {
        if (isset($this->fieldInfos[$fieldName]))
            return $this->fieldInfos[$fieldName];
        else
            return null;
    }
    // </FieldInfoList management>

    protected abstract function DoOpen();

    public abstract function Opened();

    protected function DoClose()
    {
    }

    public function GetSQL()
    {
        return $this->sql;
    }

    public function SetSQL($sql)
    {
        $this->sql = $sql;
    }

    public function SetRowLimit($value)
    {
        $this->rowLimit = $value;
    }

    public function GetRowLimit()
    {
        return $this->rowLimit;
    }

    public function GetConnection()
    {
        return $this->connection;
    }

    public function Open()
    {
        if (!$this->Opened())
        {
            $this->ClearFields();
            if (!$this->DoOpen())
            {
                RaiseError($this->LastError());
            }
            if ($this->Opened())
            {
                $this->FetchFields();
            }
        }
    }

    public function Close()
    {
        if ($this->Opened())
            $this->DoClose();
    }

    /**
     * @abstract
     * @return boolean
     */
    public abstract function Next();

    protected function LastError()
    {
        return $this->GetConnection()->LastError();
    }

    protected function GetDateTimeFieldValueByName(&$value)
    {
        if (isset($value))
            return SMDateTime::Parse($value, '%Y-%m-%d %H:%M:%S');
        else
            return null;
    }

    protected function GetDateFieldValueByName(&$value)
    {
        if (isset($value))
            return SMDateTime::Parse($value, '%Y-%m-%d');
        else
            return null;
    }

    protected function GetTimeFieldValueByName(&$value)
    {
        if (isset($value))
            return SMDateTime::Parse($value, '%H:%M:%S');
        else
            return null;
    }

    /**
     * @abstract
     * @param string $fieldName
     * @return mixed
     */
    public abstract function GetFieldValueByName($fieldName);

    protected function GetActualFieldValue(&$fieldName, $value)
    {
        $fieldInfo = $this->GetFieldInfoByFieldName($fieldName);
        if (!isset($fieldInfo))
            return $value;
        if ($fieldInfo->FieldType == ftDateTime)
            return $this->GetDateTimeFieldValueByName($value);
        elseif ($fieldInfo->FieldType == ftDate)
            return $this->GetDateFieldValueByName($value);
        elseif ($fieldInfo->FieldType == ftTime)
            return $this->GetTimeFieldValueByName($value);
        else
        {
            return $value;
        }
    }
}

?>