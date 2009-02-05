/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.principal;

import com.atlassian.crowd.integration.authentication.PasswordCredential;
import com.atlassian.crowd.integration.soap.SOAPAttribute;
import com.atlassian.crowd.integration.soap.SOAPPrincipal;
import com.atlassian.crowd.integration.model.RemotePrincipalConstants;
import com.atlassian.crowd.security.demo.action.BaseAction;

public class AddPrincipal extends BaseAction
{

    private SOAPPrincipal principal;

    protected String name;
    protected String password;
    protected String passwordConfirm;
    protected String firstname;
    protected String lastname;
    protected String email;
    protected boolean active;

    public String doDefault()
    {
        return INPUT;
    }

    public String doUpdate()
    {
        try
        {
            // check for errors
            doValidation();
            if (hasErrors() || hasActionErrors())
            {
                return INPUT;
            }

            // build our principal object
            principal = new SOAPPrincipal();
            principal.setActive(active);
            principal.setName(name);

            // set the attributes of the principal
            SOAPAttribute[] soapAttributes = new SOAPAttribute[4];

            soapAttributes[0] = buildAttribute(RemotePrincipalConstants.EMAIL, email);
            soapAttributes[1] = buildAttribute(RemotePrincipalConstants.FIRSTNAME, firstname);
            soapAttributes[2] = buildAttribute(RemotePrincipalConstants.LASTNAME, lastname);
            soapAttributes[3] = buildAttribute(RemotePrincipalConstants.DISPLAYNAME, firstname + " " + lastname);

            principal.setAttributes(soapAttributes);

            // our password
            PasswordCredential credentials = new PasswordCredential(password);

            // have the security server add it
            principal = securityServerClient.addPrincipal(principal, credentials);

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    protected void doValidation()
    {

        if (name == null || name.equals(""))
        {
            addFieldError("name", getText("principal.name.invalid"));

        }
        else
        {
            try
            {
                securityServerClient.findPrincipalByName(name);

                // this isn't good, this name already exist
                addFieldError("name", getText("invalid.namealreadyexist"));

            }
            catch (Exception e)
            {
                // ignore
            }
        }

        if (password != null && !password.equals(""))
        {

            if (passwordConfirm == null || passwordConfirm.equals(""))
            {
                addFieldError("password", getText("principal.password.invalid"));
                addFieldError("confirmPassword", "");

            }
            else if (!password.equals(passwordConfirm))
            {
                addFieldError("password", getText("principal.passwordconfirm.nomatch"));
                addFieldError("confirmPassword", "");
            }

        }
        else
        {
            addFieldError("password", getText("principal.password.invalid"));
            addFieldError("confirmPassword", "");
        }
    }

    public SOAPPrincipal getPrincipal()
    {
        return principal;
    }

    public boolean isActive()
    {
        return active;
    }

    public void setActive(boolean active)
    {
        this.active = active;
    }

    public String getEmail()
    {
        return email;
    }

    public void setEmail(String email)
    {
        this.email = email;
    }

    public String getFirstname()
    {
        return firstname;
    }

    public void setFirstname(String firstname)
    {
        this.firstname = firstname;
    }

    public String getLastname()
    {
        return lastname;
    }

    public void setLastname(String lastname)
    {
        this.lastname = lastname;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }

    public String getPassword()
    {
        return password;
    }

    public void setPassword(String password)
    {
        this.password = password;
    }

    public String getPasswordConfirm()
    {
        return passwordConfirm;
    }

    public void setPasswordConfirm(String passwordConfirm)
    {
        this.passwordConfirm = passwordConfirm;
    }
}
