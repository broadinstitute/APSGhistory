<?php


require_once 'libs/smartylibs/Smarty.class.php';
require_once 'components/renderers/list_renderer.php';
require_once 'components/captions.php';

function RaiseError($message = '')
{
    @session_destroy();
    throw new Exception($message);
}

function RaiseSecurityError($message = '')
{
    @session_destroy();
    ShowSecurityErrorPage($message);
    exit;
}

function ShowSecurityErrorPage($parentPage, $message)
{
    $renderer = new ViewAllRenderer($parentPage->GetLocalizerCaptions());
    $errorPage = new CustomErrorPage($parentPage, $parentPage->GetLocalizerCaptions()->GetMessageString('AccessDenied'), $message,
        sprintf(
            $parentPage->GetLocalizerCaptions()->GetMessageString('AccessDeniedErrorSuggesstions'),
            'login.php'
            ));
    echo $renderer->Render($errorPage);
}

function ShowErrorPage($message)
{
    $smarty = new Smarty();
    $smarty->template_dir = '/components/templates';
    $smarty->assign('Message', $message);
    $smarty->assign('Captions', GetCaptions('UTF-8'));
    $smarty->display('error_page.tpl');
}

class CustomErrorPage
{
    private $parentPage;
    private $caption;
    private $message;
    private $description;

    public function __construct($parentPage, $caption, $message, $description)
    {
        $this->parentPage = $parentPage;
        $this->caption = $caption;
        $this->message = $message;
        $this->description = $description;
    }

    public function GetPageDirection()
    {
        return null;
    }

    public function GetOnPageLoadedClientScript()
    {
        return '';
    }

    public function GetCustomClientScript()
    {
        return '';
    }

    public function GetCaption() { return $this->caption; }
    public function GetCustomPageHeader() { return ''; }
    public function GetContentEncoding() { return $this->parentPage->GetContentEncoding(); }
    public function GetHeader() { return $this->parentPage->GetHeader(); }
    public function GetMessage() { return $this->message; }
    public function GetDescription() { return $this->description; }

    public function Accept($renderer)
    {
        $renderer->RenderCustomErrorPage($this);
    }

    public function GetValidationScripts()
    {
        return '';
    }
}

?>