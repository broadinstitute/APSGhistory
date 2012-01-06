<?php

class PageLink
{
    private $caption;
    private $link;
    private $hint;
    private $showAsText;

    public function __construct($caption, $link, $hint = '', $showAsText = false)
    {
        $this->caption = $caption;
        $this->link = $link;
        $this->hint = $hint;
        $this->showAsText = $showAsText;
    }

    public function GetCaption() { return $this->caption; }
    public function GetHint() { return $this->hint; }
    public function GetShowAsText() { return $this->showAsText; }
    public function GetLink() { return $this->link; }
}

class LoginPageLink
{
    private $loginCaption;
    private $logoutCaption;

    public function __construct($loginCaption, $logoutCaption)
    {
        $this->loginCaption = $loginCaption;
        $this->logoutCaption = $logoutCaption;
    }   

    public function GetCaption()
    {
        if (GetApplication()->IsCurrentUserLoggedIn())
            return $this->logoutCaption;
        else
            return $this->loginCaption;
    }

    public function GetLink()
    {
        if (GetApplication()->IsCurrentUserLoggedIn())
            return 'login.php?operation=logout';
        else
            return 'login.php';
    }
}

class PageList
{
    private $pages;

    public function __construct()
    {
        $this->pages = array();
    }

    public function AddPage($page)
    {
        $this->pages[] = $page;
    }

    public function GetPages()
    {
        return $this->pages;
    }
    
    public function Accept($renderer)
    {
        $renderer->RenderPageList($this);
    }
}
?>
