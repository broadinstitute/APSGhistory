/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.group;

import com.atlassian.crowd.integration.soap.SOAPGroup;
import com.atlassian.crowd.security.demo.action.BaseAction;
import org.apache.log4j.Logger;

public class ViewGroup extends BaseAction
{
    private static final Logger logger = Logger.getLogger(ViewGroup.class);

    private SOAPGroup group;

    private String name;
    private String groupDescription;
    private boolean active;

    public String doDefault()
    {
        try
        {
            group = securityServerClient.findGroupByName(name);

            this.groupDescription = group.getDescription();
            this.active = group.isActive();

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return SUCCESS;
    }

    public SOAPGroup getGroup()
    {
        return group;
    }

    public String getGroupDescription()
    {
        return groupDescription;
    }

    public void setGroupDescription(String groupDescription)
    {
        this.groupDescription = groupDescription;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }

    public boolean isActive()
    {
        return active;
    }

    public void setActive(boolean active)
    {
        this.active = active;
    }
}