/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.group;

import com.atlassian.crowd.security.demo.action.BaseAction;

public class RemoveGroup extends BaseAction
{

    private String name;

    public String doDefault()
    {
        try
        {
            // make sure the group exist, display errors if there is a problem
            securityServerClient.findGroupByName(name);

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doUpdate()
    {
        try
        {

            securityServerClient.removeGroup(name);

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }
}
