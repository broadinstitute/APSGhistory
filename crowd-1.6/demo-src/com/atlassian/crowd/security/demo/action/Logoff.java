/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action;

import com.opensymphony.webwork.ServletActionContext;

public class Logoff extends BaseAction
{

    public String execute() throws Exception
    {
        httpAuthenticator.logoff(ServletActionContext.getRequest(), ServletActionContext.getResponse());

        getSession().invalidate();

        return SUCCESS;
    }
}