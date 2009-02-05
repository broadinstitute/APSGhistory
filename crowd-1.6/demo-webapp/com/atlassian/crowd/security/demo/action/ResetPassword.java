package com.atlassian.crowd.security.demo.action;

public class ResetPassword extends BaseAction
{

    private String username;

    public String doDefault()
    {
        return INPUT;
    }

    public String doUpdate()
    {
        try
        {
            doValidation();

            if (hasErrors() || hasActionErrors())
            {
                logger.debug("input error");
                return INPUT;
            }

            securityServerClient.resetPrincipalCredential(username);

            return SUCCESS;

        }
        catch (Exception e)
        {
            logger.warn(e.getMessage(), e);
            addActionError(getText("passwordreset.invalid"));
        }

        return INPUT;
    }

    protected void doValidation()
    {
        if (username == null || username.equals("") || username.length() > 50)
        {
            addFieldError("username", getText("principal.name.invalid"));
        }
    }

    public String getUsername()
    {
        return username;
    }

    public void setUsername(String username)
    {
        this.username = username;
    }
}