<?php

require_once 'components/grid/vertical_grid.php';

class InlineGridHandler extends HTTPHandler
{
    private $grid;

    public function __construct($name, VerticalGrid $grid)
    {
        parent::__construct($name);
        $this->grid = $grid;
    }

    public function Render(Renderer $renderer)
    {
        $superGlobals = GetApplication()->GetSuperGlobals();
        if ($superGlobals->GetGetValueDef(ModalOperation::Param) == ModalOperation::OpenModalEditDialog ||
            $superGlobals->GetGetValueDef(ModalOperation::Param) == ModalOperation::OpenModalInsertDialog)
        {
            $this->grid->GetGrid()->GetPage()->UpdateValuesFromUrl();
        }
        
        $this->grid->ProcessMessages();
        echo $renderer->Render($this->grid);
    }
}

class ModalDeleteHandler extends HTTPHandler
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @param string $name
     * @param Grid $grid
     */
    public function __construct($name, Grid $grid)
    {
        parent::__construct($name);
        $this->grid = $grid;
    }

    public function Render(Renderer $renderer)
    {
        try
        {
            $errorReporting = error_reporting(null);

            GetApplication()->SetOperation(OPERATION_COMMIT_DELETE);
            $this->grid->SetState(OPERATION_COMMIT_DELETE);
            $this->grid->GetState()->SetUseGetToExtractPrimaryKeys(true);
            $this->grid->ProcessMessages();

            header('Content-Type: text/xml');

            if ($this->grid->GetErrorMessage() != '')
            {
                $xmlWriter = XMLWriterFactory::CreateXMLWriter();
                $xmlWriter->StartDocument('1.0', 'UTF-8');
                $xmlWriter->StartElement('response');
                $xmlWriter->WriteElement('type', 'error');
                $xmlWriter->WriteElement('error_message', $this->grid->GetErrorMessage());
                $xmlWriter->EndElement('response');
                echo $xmlWriter->GetResult();
            }
            else
            {
                $xmlWriter = XMLWriterFactory::CreateXMLWriter();
                $xmlWriter->StartDocument('1.0', 'UTF-8');
                $xmlWriter->StartElement('response');
                $xmlWriter->WriteElement('type', 'OK');
                $xmlWriter->EndElement('response');
                echo $xmlWriter->GetResult();
            }
            
            error_reporting($errorReporting);
        }
        catch(Exception $e)
        {
            echo '<?xml version="1.0" encoding="UTF-8"?><response><type>error</type><error_message>'.
                    htmlspecialchars($e->getMessage()).
                    '</error_message></response>';
        }

    }
}

?>