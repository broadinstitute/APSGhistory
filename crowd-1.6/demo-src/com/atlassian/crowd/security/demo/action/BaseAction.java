/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action;

import com.atlassian.crowd.integration.exception.InvalidPrincipalException;
import com.atlassian.crowd.integration.http.HttpAuthenticator;
import com.atlassian.crowd.integration.service.soap.client.SecurityServerClient;
import com.atlassian.crowd.integration.soap.SOAPAttribute;
import com.atlassian.crowd.integration.soap.SOAPPrincipal;
import com.atlassian.crowd.integration.model.RemotePrincipalConstants;
import com.opensymphony.util.TextUtils;
import com.opensymphony.webwork.ServletActionContext;
import com.opensymphony.xwork.ActionSupport;
import org.apache.log4j.Logger;

import javax.servlet.http.HttpSession;

public class BaseAction extends ActionSupport
{
    protected final Logger logger = Logger.getLogger(this.getClass());

    protected int tab = 1;
    protected SOAPPrincipal remotePrincipal;
    protected Boolean authenticated = null;

    protected SecurityServerClient securityServerClient;
    protected HttpAuthenticator httpAuthenticator;

    public String doDefault() {
        return SUCCESS;
    }

    public String getPrincipalName() throws InvalidPrincipalException {
        if (!isAuthenticated())
            return null;

        String principalName = "";

        if (getRemotePrincipal() != null)
        {
            String firstName = getFirstAttribute(RemotePrincipalConstants.FIRSTNAME);
            String lastName = getFirstAttribute(RemotePrincipalConstants.LASTNAME);

            if (TextUtils.stringSet(firstName))
            {
                principalName = firstName;
            }

            if (TextUtils.stringSet(lastName))
            {
                if (TextUtils.stringSet(principalName) && principalName.length() > 0)
                    principalName += " ";

                principalName += lastName;
            }

            if (!TextUtils.stringSet(principalName))
                principalName = getRemotePrincipal().getName();
        }

        return principalName;
    }

    public SOAPPrincipal getRemotePrincipal() throws InvalidPrincipalException
    {
        if (!isAuthenticated())
            return null;

        if (remotePrincipal == null)
        {

            try
            {
                // find the principal off their authenticated token key.
                remotePrincipal = httpAuthenticator.getPrincipal(ServletActionContext.getRequest());
            }
            catch (Exception e)
            {
                logger.info(e.getMessage(), e);

                throw new InvalidPrincipalException(e.getMessage(), e);
            }
        }

        return remotePrincipal;
    }

    public String getFirstAttribute(String name) throws InvalidPrincipalException
    {
        SOAPAttribute attribute = getAttribute(name);

        if (attribute == null)
            return null;

        if (attribute.getValues().length > 0)
            return attribute.getValues()[0];

        return null;
    }

    /**
     * Checks if a principal is currently authenticated verses the Crowd security server. 
     * @return <code>true</code> if and only if the principal is currently authenticated, otherwise <code>false</code>.
     */
    public boolean isAuthenticated()
    {
        if (authenticated == null) {
            try {
                authenticated = httpAuthenticator.isAuthenticated(ServletActionContext.getRequest(), ServletActionContext.getResponse());
            }
            catch (Exception e) {
                logger.info(e.getMessage(), e);
                authenticated = Boolean.FALSE;
            }
        }
        return authenticated;
    }

    public SOAPAttribute getAttribute(String name) throws InvalidPrincipalException
    {
        if (!isAuthenticated()) {
            return null;
        }

        SOAPPrincipal remotePrincipal = getRemotePrincipal();

        SOAPAttribute[] attributes = remotePrincipal.getAttributes();

        for (int i = 0; i < attributes.length; i++) {
            if (attributes[i].getName().equals(name)) {
                return attributes[i];
            }
        }

        // unable to find the attribute, return a new empty one.
        SOAPAttribute soapAttribute = new SOAPAttribute();
        soapAttribute.setName(name);

        return soapAttribute;
    }

    public SOAPAttribute buildAttribute(String key, String value) {
        SOAPAttribute attribute = new SOAPAttribute();

        attribute.setName(key);
        attribute.setValues(new String[1]);
        attribute.getValues()[0] = value;

        return attribute;
    }

    public SOAPAttribute buildAttribute(String key, String[] values) {
        SOAPAttribute attribute = new SOAPAttribute();

        attribute.setName(key);
        attribute.setValues(values);

        return attribute;
    }

    protected HttpSession getSession () {
        return ServletActionContext.getRequest().getSession();
    }

    public int getTab() {
        return tab;
    }

    public void setTab(int tab) {
        this.tab = tab;
    }

    public SecurityServerClient getSecurityServerClient()
    {
        return securityServerClient;
    }

    public void setSecurityServerClient(SecurityServerClient securityServerClient)
    {
        this.securityServerClient = securityServerClient;
    }

    public HttpAuthenticator getHttpAuthenticator()
    {
        return httpAuthenticator;
    }

    public void setHttpAuthenticator(HttpAuthenticator httpAuthenticator)
    {
        this.httpAuthenticator = httpAuthenticator;
    }
}